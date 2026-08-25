<?php

require_once __DIR__ . '/../models/ChatConversation.php';
require_once __DIR__ . '/../models/ChatMessage.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../services/AIService.php';
require_once __DIR__ . '/../../config/security.php';

class ChatController
{
    private ChatConversation $conversationModel;
    private ChatMessage $messageModel;
    private User $userModel;
    private AIService $aiService;

    public function __construct()
    {
        $this->conversationModel = new ChatConversation();
        $this->messageModel = new ChatMessage();
        $this->userModel = new User();
        $this->aiService = new AIService();
    }

    /**
     * Initialize or resume chat session via AJAX
     */
    public function initSession(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = trim($_GET['session_id'] ?? ($_POST['session_id'] ?? ''));
        if ($sessionId === '') {
            $sessionId = 'SKM-CHAT-' . bin2hex(random_bytes(16));
        }

        $userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $currentUser = null;

        if ($userId) {
            $currentUser = $this->userModel->findById($userId);
        }

        $visitorName = $currentUser ? $currentUser['name'] : null;
        $visitorEmail = $currentUser ? $currentUser['email'] : null;
        $visitorPhone = $currentUser ? $currentUser['phone'] : null;

        // Privacy check: If conversation belongs to another registered user, isolate by generating new session
        $existingConv = $this->conversationModel->findBySessionId($sessionId);
        if ($existingConv && !empty($existingConv['user_id']) && ($userId === null || (int) $userId !== (int) $existingConv['user_id'])) {
            $sessionId = 'SKM-CHAT-' . bin2hex(random_bytes(16));
        }

        $conversation = $this->conversationModel->getOrCreate($sessionId, $visitorName, $visitorEmail, $visitorPhone, $userId);
        $messages = $this->messageModel->getByConversationId((int) $conversation['id'], 20);

        echo json_encode([
            'success' => true,
            'session_id' => $sessionId,
            'conversation_id' => (int) $conversation['id'],
            'logged_in' => ($currentUser !== null),
            'user' => $currentUser ? [
                'id' => (int) $currentUser['id'],
                'name' => $currentUser['name'],
                'email' => $currentUser['email'],
                'avatar' => $currentUser['avatar'] ?? '',
                'phone' => $currentUser['phone'] ?? '',
                'company' => $currentUser['company'] ?? '',
            ] : null,
            'messages' => $messages,
            'company_info' => [
                'name' => 'PT Samudra Kencana Mina',
                'phone' => '+62 31 8547202',
                'whatsapp' => '62318547202',
            ]
        ]);
        exit;
    }

    /**
     * Send message to AI and return AI response
     */
    public function send(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'error' => 'Metode request tidak diizinkan.']);
            exit;
        }

        $sessionId = trim($_POST['session_id'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if ($sessionId === '' || $message === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Pesan tidak boleh kosong.']);
            exit;
        }

        if (mb_strlen($message, 'UTF-8') > 3000) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Pesan terlalu panjang (maksimal 3000 karakter).']);
            exit;
        }

        $userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $currentUser = $userId ? $this->userModel->findById($userId) : null;

        $visitorName = $currentUser ? $currentUser['name'] : null;
        $visitorEmail = $currentUser ? $currentUser['email'] : null;
        $visitorPhone = $currentUser ? $currentUser['phone'] : null;

        // Privacy check: If conversation belongs to another registered user, isolate
        $existingConv = $this->conversationModel->findBySessionId($sessionId);
        if ($existingConv && !empty($existingConv['user_id']) && ($userId === null || (int) $userId !== (int) $existingConv['user_id'])) {
            $sessionId = 'SKM-CHAT-' . bin2hex(random_bytes(16));
        }

        $conversation = $this->conversationModel->getOrCreate($sessionId, $visitorName, $visitorEmail, $visitorPhone, $userId);
        $conversationId = (int) $conversation['id'];

        // 1. Save user message to database
        $userMsgId = $this->messageModel->create($conversationId, 'user', $message);

        // 2. Fetch recent conversation history (latest 12 messages for prompt efficiency)
        $history = $this->messageModel->getByConversationId($conversationId, 12);

        // 3. Call AI Service with optional customer context
        $customerContext = $currentUser ? [
            'name' => $currentUser['name'],
            'email' => $currentUser['email'],
            'phone' => $currentUser['phone'] ?? '',
            'company' => $currentUser['company'] ?? '',
        ] : null;

        $aiResult = $this->aiService->generateResponse($history, $message, $customerContext);
        $aiMessage = $aiResult['message'] ?? 'Maaf, saya sedang mengalami kendala jaringan. Silakan hubungi tim kami di +62 31 8547202.';

        // 4. Save AI message to database
        $aiMsgId = $this->messageModel->create($conversationId, 'ai', $aiMessage);

        // Check if there is inquiry JSON embedded in the response
        $inquiryData = null;
        if (preg_match('/```inquiry_data\s*(\{.*?\})\s*```/s', $aiMessage, $matches)) {
            $jsonParsed = json_decode($matches[1], true);
            if (is_array($jsonParsed)) {
                $inquiryData = $jsonParsed;
            }
        }

        echo json_encode([
            'success' => true,
            'session_id' => $sessionId,
            'user_message' => [
                'id' => $userMsgId,
                'message' => $message,
                'created_at' => date('Y-m-d H:i:s'),
            ],
            'ai_response' => [
                'id' => $aiMsgId,
                'message' => $aiMessage,
                'created_at' => date('Y-m-d H:i:s'),
                'inquiry_data' => $inquiryData,
            ],
        ]);
        exit;
    }

    /**
     * Get chat history for session with pagination
     */
    public function history(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $sessionId = trim($_GET['session_id'] ?? '');

        if ($sessionId === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Session ID tidak valid.']);
            exit;
        }

        $conversation = $this->conversationModel->findBySessionId($sessionId);

        if (!$conversation) {
            echo json_encode(['success' => true, 'messages' => []]);
            exit;
        }

        // Privacy check: If conversation belongs to a registered customer, require same customer session or admin
        if (!empty($conversation['user_id'])) {
            $currentUserId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
            $isAdmin = isset($_SESSION['admin_id']);
            if (!$isAdmin && ($currentUserId === null || $currentUserId !== (int) $conversation['user_id'])) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Akses percakapan tidak diizinkan.']);
                exit;
            }
        }

        $limit = isset($_GET['limit']) ? min((int) $_GET['limit'], 50) : 20;
        $messages = $this->messageModel->getByConversationId((int) $conversation['id'], $limit);

        echo json_encode([
            'success' => true,
            'conversation' => $conversation,
            'messages' => $messages,
        ]);
        exit;
    }

    /**
     * Admin view of all conversations
     */
    public function adminIndex(): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        $conversations = $this->conversationModel->getAll(100, 0);

        require_once __DIR__ . '/../views/admin/chat/index.php';
    }

    /**
     * Admin view of specific conversation
     */
    public function adminShow(int $id): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        $conversation = $this->conversationModel->getById($id);

        if (!$conversation) {
            $_SESSION['error'] = 'Percakapan tidak ditemukan.';
            header('Location: ?route=admin/chat');
            exit;
        }

        $messages = $this->messageModel->getByConversationId($id, 200);

        require_once __DIR__ . '/../views/admin/chat/show.php';
    }
}
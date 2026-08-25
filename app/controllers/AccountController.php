<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Inquiry.php';
require_once __DIR__ . '/../models/ChatConversation.php';
require_once __DIR__ . '/../models/ChatMessage.php';
require_once __DIR__ . '/../../config/security.php';

class AccountController
{
    private User $userModel;
    private Inquiry $inquiryModel;
    private ChatConversation $chatConvModel;
    private ChatMessage $chatMsgModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->inquiryModel = new Inquiry();
        $this->chatConvModel = new ChatConversation();
        $this->chatMsgModel = new ChatMessage();
    }

    private function requireAuth(): int
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?route=auth/login&return_to=' . urlencode($_SERVER['REQUEST_URI'] ?? '?route=account'));
            exit;
        }
        return (int) $_SESSION['user_id'];
    }

    /**
     * Customer Profile & Activity Dashboard
     */
    public function index(): void
    {
        $userId = $this->requireAuth();
        $user = $this->userModel->findById($userId);

        if (!$user) {
            unset($_SESSION['user_id']);
            header('Location: ?route=auth/login');
            exit;
        }

        $stats = $this->userModel->getStats($userId);
        $inquiries = $this->inquiryModel->getByUserId($userId, 20);
        $conversations = $this->chatConvModel->getByUserId($userId, 10);

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        require_once __DIR__ . '/../views/account/index.php';
    }

    /**
     * Customer Inquiry Detail & Tracking Timeline
     */
    public function inquiryDetail(): void
    {
        $userId = $this->requireAuth();
        $inquiryId = (int) ($_GET['id'] ?? 0);

        // Strict ownership validation (IDOR Prevention)
        $inquiry = $this->inquiryModel->findByIdAndUserId($inquiryId, $userId);

        if (!$inquiry) {
            http_response_code(404);
            echo "Permintaan penawaran tidak ditemukan atau Anda tidak memiliki akses.";
            exit;
        }

        require_once __DIR__ . '/../views/account/inquiry.php';
    }

    /**
     * Update Profile Phone & Company
     */
    public function updateProfile(): void
    {
        $userId = $this->requireAuth();
        require_valid_csrf();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=account');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $company = trim($_POST['company'] ?? '');

        if ($name === '') {
            $_SESSION['flash_error'] = 'Nama lengkap tidak boleh kosong.';
            header('Location: ?route=account');
            exit;
        }

        $updated = $this->userModel->updateProfile($userId, [
            'name' => $name,
            'phone' => $phone,
            'company' => $company,
        ]);

        if ($updated) {
            $_SESSION['user_name'] = $name;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_company'] = $company;
            $_SESSION['flash_success'] = 'Profil Anda berhasil diperbarui.';
        } else {
            $_SESSION['flash_error'] = 'Gagal memperbarui profil.';
        }

        header('Location: ?route=account');
        exit;
    }
}
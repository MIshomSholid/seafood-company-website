<?php

require_once __DIR__ . '/../../config/database.php';

class ChatConversation
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findBySessionId(string $sessionId): ?array
    {
        $stmt = $this->db->prepare("
            SELECT c.*, u.name AS user_name, u.email AS user_email, u.avatar AS user_avatar
            FROM chat_conversations c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.session_id = :session_id
            LIMIT 1
        ");
        $stmt->execute(['session_id' => $sessionId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function getOrCreate(string $sessionId, ?string $name = null, ?string $email = null, ?string $phone = null, ?int $userId = null): array
    {
        $conversation = $this->findBySessionId($sessionId);
        if ($conversation) {
            // If user just logged in, link user_id
            if ($userId !== null && empty($conversation['user_id'])) {
                $this->linkGuestConversationToUser($sessionId, $userId);
                return $this->getById((int) $conversation['id']) ?: $conversation;
            }
            return $conversation;
        }

        $stmt = $this->db->prepare("
            INSERT INTO chat_conversations (user_id, session_id, visitor_name, visitor_email, visitor_phone, title, status)
            VALUES (:user_id, :session_id, :visitor_name, :visitor_email, :visitor_phone, :title, 'active')
        ");
        $stmt->execute([
            'user_id' => $userId,
            'session_id' => $sessionId,
            'visitor_name' => $name,
            'visitor_email' => $email,
            'visitor_phone' => $phone,
            'title' => 'Percakapan AI - ' . date('d M Y H:i'),
        ]);

        $id = (int) $this->db->lastInsertId();
        return $this->getById($id) ?: ['id' => $id, 'session_id' => $sessionId, 'user_id' => $userId];
    }

    public function linkGuestConversationToUser(string $sessionId, int $userId): bool
    {
        $stmt = $this->db->prepare("
            UPDATE chat_conversations
            SET user_id = :user_id,
                updated_at = CURRENT_TIMESTAMP
            WHERE session_id = :session_id AND (user_id IS NULL OR user_id = :existing_uid)
        ");
        return $stmt->execute([
            'user_id' => $userId,
            'existing_uid' => $userId,
            'session_id' => $sessionId,
        ]);
    }

    public function getByUserId(int $userId, int $limit = 20): array
    {
        $stmt = $this->db->prepare("
            SELECT c.*, COUNT(m.id) as message_count
            FROM chat_conversations c
            LEFT JOIN chat_messages m ON c.id = m.conversation_id
            WHERE c.user_id = :user_id
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT c.*, u.name AS user_name, u.email AS user_email, u.avatar AS user_avatar, u.phone AS user_phone, u.company AS user_company
            FROM chat_conversations c
            LEFT JOIN users u ON c.user_id = u.id
            WHERE c.id = :id
            LIMIT 1
        ");
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function updateVisitorInfo(int $id, ?string $name, ?string $email, ?string $phone): bool
    {
        $stmt = $this->db->prepare("
            UPDATE chat_conversations
            SET visitor_name = COALESCE(:name, visitor_name),
                visitor_email = COALESCE(:email, visitor_email),
                visitor_phone = COALESCE(:phone, visitor_phone),
                updated_at = CURRENT_TIMESTAMP
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
        ]);
    }

    public function getAll(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db->prepare("
            SELECT c.*, 
                   COUNT(m.id) as message_count,
                   u.name AS registered_name,
                   u.email AS registered_email,
                   u.avatar AS registered_avatar
            FROM chat_conversations c
            LEFT JOIN users u ON c.user_id = u.id
            LEFT JOIN chat_messages m ON c.id = m.conversation_id
            GROUP BY c.id
            ORDER BY c.updated_at DESC
            LIMIT :limit OFFSET :offset
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getCount(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM chat_conversations");
        return (int) $stmt->fetchColumn();
    }
}
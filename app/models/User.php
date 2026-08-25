<?php

require_once __DIR__ . '/../../config/database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id LIMIT 1");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => strtolower(trim($email))]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function findByGoogleId(string $googleId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE google_id = :google_id LIMIT 1");
        $stmt->execute(['google_id' => $googleId]);
        $user = $stmt->fetch();
        return $user ?: null;
    }

    public function createOrUpdateFromGoogle(array $data): array
    {
        $googleId = trim($data['google_id'] ?? '');
        $email = strtolower(trim($data['email'] ?? ''));
        $name = trim($data['name'] ?? 'Pelanggan');
        $avatar = trim($data['avatar'] ?? '');

        // 1. Try find by google_id or email
        $existing = null;
        if ($googleId !== '') {
            $existing = $this->findByGoogleId($googleId);
        }
        if (!$existing && $email !== '') {
            $existing = $this->findByEmail($email);
        }

        if ($existing) {
            // Update existing user with latest Google info & last_login_at
            $stmt = $this->db->prepare("
                UPDATE users
                SET google_id = COALESCE(:google_id, google_id),
                    name = :name,
                    avatar = COALESCE(:avatar, avatar),
                    last_login_at = NOW()
                WHERE id = :id
            ");
            $stmt->execute([
                'id' => (int) $existing['id'],
                'google_id' => $googleId ?: $existing['google_id'],
                'name' => $name ?: $existing['name'],
                'avatar' => $avatar ?: $existing['avatar'],
            ]);

            return $this->findById((int) $existing['id']);
        }

        // Insert new user
        $stmt = $this->db->prepare("
            INSERT INTO users (google_id, name, email, avatar, last_login_at)
            VALUES (:google_id, :name, :email, :avatar, NOW())
        ");
        $stmt->execute([
            'google_id' => $googleId ?: null,
            'name' => $name,
            'email' => $email,
            'avatar' => $avatar ?: null,
        ]);

        $newId = (int) $this->db->lastInsertId();
        return $this->findById($newId);
    }

    public function updateProfile(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET name = :name,
                phone = :phone,
                company = :company
            WHERE id = :id
        ");
        return $stmt->execute([
            'id' => $id,
            'name' => trim($data['name'] ?? ''),
            'phone' => trim($data['phone'] ?? ''),
            'company' => trim($data['company'] ?? ''),
        ]);
    }

    public function getStats(int $userId): array
    {
        // Total inquiries
        $stmtInq = $this->db->prepare("SELECT COUNT(*) FROM inquiries WHERE user_id = :uid");
        $stmtInq->execute(['uid' => $userId]);
        $totalInquiries = (int) $stmtInq->fetchColumn();

        // Active inquiries (not completed/cancelled)
        $stmtActive = $this->db->prepare("SELECT COUNT(*) FROM inquiries WHERE user_id = :uid AND status NOT IN ('completed', 'cancelled')");
        $stmtActive->execute(['uid' => $userId]);
        $activeInquiries = (int) $stmtActive->fetchColumn();

        // Total conversations
        $stmtConv = $this->db->prepare("SELECT COUNT(*) FROM chat_conversations WHERE user_id = :uid");
        $stmtConv->execute(['uid' => $userId]);
        $totalConversations = (int) $stmtConv->fetchColumn();

        return [
            'total_inquiries' => $totalInquiries,
            'active_inquiries' => $activeInquiries,
            'total_conversations' => $totalConversations,
        ];
    }
}
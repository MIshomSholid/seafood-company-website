<?php

require_once __DIR__ . '/../../config/database.php';

class ChatMessage
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(int $conversationId, string $senderType, string $message): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO chat_messages (conversation_id, sender_type, message, created_at)
            VALUES (:conversation_id, :sender_type, :message, CURRENT_TIMESTAMP)
        ");
        $stmt->execute([
            'conversation_id' => $conversationId,
            'sender_type' => $senderType,
            'message' => $message,
        ]);

        $insertId = (int) $this->db->lastInsertId();

        // Touch parent conversation updated_at
        $updateStmt = $this->db->prepare("UPDATE chat_conversations SET updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        $updateStmt->execute(['id' => $conversationId]);

        return $insertId;
    }

    public function getByConversationId(int $conversationId, int $limit = 60): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM (
                SELECT * FROM chat_messages
                WHERE conversation_id = :conversation_id
                ORDER BY id DESC
                LIMIT :limit
            ) sub ORDER BY id ASC
        ");
        $stmt->bindValue(':conversation_id', $conversationId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
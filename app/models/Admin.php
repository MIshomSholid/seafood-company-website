<?php

require_once __DIR__ . '/../../config/database.php';

class Admin
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Mencari admin berdasarkan username.
     */
    public function findByUsername(string $username): ?array
    {
        $sql = "
            SELECT
                id,
                username,
                password,
                name,
                created_at,
                updated_at
            FROM admins
            WHERE username = :username
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':username' => $username,
        ]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        return $admin ?: null;
    }

    /**
     * Mencari admin berdasarkan ID.
     */
    public function findById(int $id): ?array
    {
        $sql = "
            SELECT
                id,
                username,
                name,
                created_at,
                updated_at
            FROM admins
            WHERE id = :id
            LIMIT 1
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id' => $id,
        ]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        return $admin ?: null;
    }
}
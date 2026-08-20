<?php

require_once __DIR__ . '/../../config/database.php';

class Comment
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $query = "
            SELECT *
            FROM comments
            ORDER BY id DESC
        ";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $query = "
            SELECT *
            FROM comments
            WHERE id = :id
            LIMIT 1
        ";

        $statement = $this->db->prepare($query);

        $statement->execute([
            'id' => $id,
        ]);

        $comment = $statement->fetch();

        return $comment ?: null;
    }

    public function create(
        string $name,
        string $comment
    ): bool {
        $query = "
            INSERT INTO comments
                (name, comment)
            VALUES
                (:name, :comment)
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'name' => $name,
            'comment' => $comment,
        ]);
    }

    public function update(
        int $id,
        string $name,
        string $comment
    ): bool {
        $query = "
            UPDATE comments
            SET
                name = :name,
                comment = :comment
            WHERE id = :id
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'id' => $id,
            'name' => $name,
            'comment' => $comment,
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "
            DELETE FROM comments
            WHERE id = :id
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'id' => $id,
        ]);
    }
}
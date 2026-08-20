<?php

require_once __DIR__ . '/../../config/database.php';

class Product
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM products ORDER BY id DESC";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM products WHERE id = :id LIMIT 1";

        $statement = $this->db->prepare($query);
        $statement->execute([
            'id' => $id,
        ]);

        $product = $statement->fetch();

        return $product ?: null;
    }

    public function create(
        string $name,
        string $description,
        int $stock,
        ?string $image = null
    ): bool {
        $query = "
            INSERT INTO products
                (name, description, stock, image)
            VALUES
                (:name, :description, :stock, :image)
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'name' => $name,
            'description' => $description,
            'stock' => $stock,
            'image' => $image,
        ]);
    }

    public function update(
        int $id,
        string $name,
        string $description,
        int $stock,
        ?string $image = null
    ): bool {
        $query = "
            UPDATE products
            SET
                name = :name,
                description = :description,
                stock = :stock,
                image = :image
            WHERE id = :id
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'stock' => $stock,
            'image' => $image,
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "DELETE FROM products WHERE id = :id";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'id' => $id,
        ]);
    }
}
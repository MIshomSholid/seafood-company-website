<?php

require_once __DIR__ . '/../../config/database.php';

class Rating
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getAll(): array
    {
        $query = "
            SELECT
                ratings.*,
                products.name AS product_name
            FROM ratings
            INNER JOIN products
                ON ratings.product_id = products.id
            ORDER BY ratings.id DESC
        ";

        $statement = $this->db->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getByProduct(int $productId): array
    {
        $query = "
            SELECT *
            FROM ratings
            WHERE product_id = :product_id
            ORDER BY id DESC
        ";

        $statement = $this->db->prepare($query);

        $statement->execute([
            'product_id' => $productId,
        ]);

        return $statement->fetchAll();
    }

    public function getAverageByProduct(int $productId): float
    {
        $query = "
            SELECT AVG(rating) AS average_rating
            FROM ratings
            WHERE product_id = :product_id
        ";

        $statement = $this->db->prepare($query);

        $statement->execute([
            'product_id' => $productId,
        ]);

        $result = $statement->fetch();

        return $result['average_rating']
            ? round((float) $result['average_rating'], 2)
            : 0;
    }

    public function getCountByProduct(int $productId): int
    {
        $query = "
            SELECT COUNT(*) AS total_rating
            FROM ratings
            WHERE product_id = :product_id
        ";

        $statement = $this->db->prepare($query);

        $statement->execute([
            'product_id' => $productId,
        ]);

        $result = $statement->fetch();

        return (int) $result['total_rating'];
    }

    public function create(
        int $productId,
        int $rating
    ): bool {
        $query = "
            INSERT INTO ratings
                (product_id, rating)
            VALUES
                (:product_id, :rating)
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'product_id' => $productId,
            'rating' => $rating,
        ]);
    }

    public function delete(int $id): bool
    {
        $query = "
            DELETE FROM ratings
            WHERE id = :id
        ";

        $statement = $this->db->prepare($query);

        return $statement->execute([
            'id' => $id,
        ]);
    }
}
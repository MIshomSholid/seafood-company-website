<?php

require_once __DIR__ . '/../models/Rating.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../../config/security.php';

class RatingController
{
    private Rating $ratingModel;
    private Product $productModel;

    public function __construct()
    {
        $this->ratingModel = new Rating();
        $this->productModel = new Product();
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=home#produk');
            exit;
        }

        require_valid_csrf();

        $productId = (int) ($_POST['product_id'] ?? 0);
        $rating = (int) ($_POST['rating'] ?? 0);

        if ($productId <= 0 || $rating < 1 || $rating > 5) {
            header('Location: ?route=home#produk');
            exit;
        }

        $product = $this->productModel->getById($productId);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        $this->ratingModel->create(
            $productId,
            $rating
        );

        header('Location: ?route=home#produk');
        exit;
    }

    public function getProductRating(int $productId): array
    {
        return [
            'average' => $this->ratingModel->getAverageByProduct($productId),
            'count' => $this->ratingModel->getCountByProduct($productId),
        ];
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=home#produk');
            exit;
        }

        require_valid_csrf();

        $this->ratingModel->delete($id);

        header('Location: ?route=home#produk');
        exit;
    }
}
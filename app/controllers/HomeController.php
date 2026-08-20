<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../models/Rating.php';

class HomeController
{
    private Product $productModel;
    private Comment $commentModel;
    private Rating $ratingModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->commentModel = new Comment();
        $this->ratingModel = new Rating();
    }

    public function index(): void
    {
        $products = $this->productModel->getAll();
        $comments = $this->commentModel->getAll();

        $ratings = [];

        foreach ($products as $product) {
            $ratings[$product['id']] = [
                'average' => $this->ratingModel->getAverageByProduct(
                    (int) $product['id']
                ),
                'count' => $this->ratingModel->getCountByProduct(
                    (int) $product['id']
                ),
            ];
        }

        require_once __DIR__ . '/../views/home/index.php';
    }
}
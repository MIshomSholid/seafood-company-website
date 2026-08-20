<?php

require_once __DIR__ . '/../models/Comment.php';
require_once __DIR__ . '/../../config/security.php';

class CommentController
{
    private Comment $commentModel;

    public function __construct()
    {
        $this->commentModel = new Comment();
    }

    public function index(): void
    {
        $comments = $this->commentModel->getAll();

        require_once __DIR__ . '/../views/comments/index.php';
    }

    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=home#forum');
            exit;
        }

        require_valid_csrf();

        $name = trim($_POST['name'] ?? 'User');
        $comment = trim($_POST['comment'] ?? '');

        if ($comment === '' || strlen($comment) > 5000 || strlen($name) > 255) {
            header('Location: ?route=home#forum');
            exit;
        }

        if ($name === '') {
            $name = 'User';
        }

        $this->commentModel->create($name, $comment);

        header('Location: ?route=home#forum');
        exit;
    }

    public function update(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=home#forum');
            exit;
        }

        require_valid_csrf();

        $name = trim($_POST['name'] ?? 'User');
        $comment = trim($_POST['comment'] ?? '');

        if ($comment === '' || strlen($comment) > 5000 || strlen($name) > 255) {
            header('Location: ?route=home#forum');
            exit;
        }

        if ($name === '') {
            $name = 'User';
        }

        $existingComment = $this->commentModel->getById($id);

        if (!$existingComment) {
            http_response_code(404);
            echo 'Komentar tidak ditemukan.';
            return;
        }

        $this->commentModel->update(
            $id,
            $name,
            $comment
        );

        header('Location: ?route=home#forum');
        exit;
    }

    public function delete(int $id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=home#forum');
            exit;
        }

        require_valid_csrf();

        $this->commentModel->delete($id);

        header('Location: ?route=home#forum');
        exit;
    }
}
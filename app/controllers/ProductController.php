<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../../config/security.php';

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC PRODUCTS
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan daftar produk untuk pengunjung.
     */
    public function index(): void
    {
        $products = $this->productModel->getAll();

        require_once __DIR__ . '/../views/products/index.php';
    }

    /**
     * Menampilkan detail produk untuk pengunjung.
     */
    public function show(int $id): void
    {
        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        require_once __DIR__ . '/../views/products/show.php';
    }


    /*
    |--------------------------------------------------------------------------
    | ADMIN PRODUCTS
    |--------------------------------------------------------------------------
    */

    /**
     * Memastikan admin sudah login.
     */
    private function requireAdmin(): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }
    }

    /**
     * Menampilkan daftar produk di panel admin.
     */
    public function adminIndex(): void
    {
        $this->requireAdmin();

        $products = $this->productModel->getAll();

        require_once __DIR__ . '/../views/admin/products/index.php';
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function adminCreate(): void
    {
        $this->requireAdmin();

        require_once __DIR__ . '/../views/admin/products/create.php';
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=admin/products');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        require_valid_csrf();

        $stockInput = $_POST['stock'] ?? '';
        $stock = filter_var($stockInput, FILTER_VALIDATE_INT);

        if (!$this->validProductInput($name, $description, $stock)) {
            $_SESSION['error'] = 'Nama dan deskripsi wajib diisi, sedangkan stok harus berupa angka 0 atau lebih.';
            header('Location: ?route=admin/products/create');
            exit;
        }

        try {
            $image = $this->storeUploadedImage();
            $this->productModel->create($name, $description, $stock, $image);
        } catch (Throwable $exception) {
            if (isset($image) && $image !== null) {
                $this->deleteProductImage($image);
            }

            $_SESSION['error'] = 'Terjadi kesalahan saat menyimpan produk.';
            header('Location: ?route=admin/products/create');
            exit;
        }

        header('Location: ?route=admin/products');
        exit;
    }

    /**
     * Menampilkan form edit produk.
     */
    public function adminShow(int $id): void
    {
        $this->requireAdmin();

        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        require_once __DIR__ . '/../views/admin/products/show.php';
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(int $id): void
    {
        $this->requireAdmin();

        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        require_once __DIR__ . '/../views/admin/products/edit.php';
    }

    /**
     * Memperbarui produk.
     */
    public function update(int $id): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=admin/products');
            exit;
        }

        require_valid_csrf();

        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $stockInput = $_POST['stock'] ?? '';
        $stock = filter_var($stockInput, FILTER_VALIDATE_INT);

        if (!$this->validProductInput($name, $description, $stock)) {
            $_SESSION['error'] = 'Nama dan deskripsi wajib diisi, sedangkan stok harus berupa angka 0 atau lebih.';
            header('Location: ?route=admin/products/edit&id=' . $id);
            exit;
        }

        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        $oldImage = !empty($product['image']) ? basename($product['image']) : null;
        try {
            $newImage = $this->storeUploadedImage();
            $image = $newImage ?? $oldImage;
            $this->productModel->update($id, $name, $description, $stock, $image);
        } catch (Throwable $exception) {
            if (isset($newImage) && $newImage !== null) {
                $this->deleteProductImage($newImage);
            }

            $_SESSION['error'] = 'Terjadi kesalahan saat memperbarui produk.';
            header('Location: ?route=admin/products/edit&id=' . $id);
            exit;
        }

        if (isset($newImage) && $newImage !== null && $oldImage !== null) {
            $this->deleteProductImage($oldImage);
        }

        header('Location: ?route=admin/products');
        exit;
    }

    /**
     * Menghapus produk.
     */
    public function delete(int $id): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=admin/products');
            exit;
        }

        require_valid_csrf();

        $product = $this->productModel->getById($id);

        if (!$product) {
            http_response_code(404);
            echo 'Produk tidak ditemukan.';
            return;
        }

        try {
            $deleted = $this->productModel->delete($id);
        } catch (Throwable $exception) {
            $_SESSION['error'] = 'Terjadi kesalahan saat menghapus produk.';
            header('Location: ?route=admin/products');
            exit;
        }

        if ($deleted && !empty($product['image'])) {
            $this->deleteProductImage(basename($product['image']));
        }

        header('Location: ?route=admin/products');
        exit;
    }

    private function validProductInput(string $name, string $description, mixed $stock): bool
    {
        return $name !== ''
            && $description !== ''
            && strlen($name) <= 255
            && strlen($description) <= 5000
            && $stock !== false
            && $stock !== null
            && $stock >= 0;
    }

    private function storeUploadedImage(): ?string
    {
        if (
            !isset($_FILES['image']) ||
            $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return null;
        }

        $file = $_FILES['image'];

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RuntimeException('Gambar gagal diupload.');
        }

        if ($file['size'] > 2 * 1024 * 1024) {
            throw new RuntimeException('Ukuran gambar maksimal 2 MB.');
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RuntimeException('File upload tidak valid.');
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        if (!$finfo) {
            throw new RuntimeException('Tidak dapat memeriksa tipe file.');
        }

        $mimeType = finfo_file($finfo, $file['tmp_name']);

        $allowedMimeTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (
            !is_string($mimeType) ||
            !isset($allowedMimeTypes[$mimeType])
        ) {
            throw new RuntimeException(
                'Format gambar harus JPG, PNG, atau WEBP.'
            );
        }

        // Memastikan file benar-benar merupakan gambar.
        if (@getimagesize($file['tmp_name']) === false) {
            throw new RuntimeException('File bukan gambar yang valid.');
        }

        $directory = dirname(__DIR__, 2) . '/public/assets/images';

        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true)) {
                throw new RuntimeException(
                    'Folder penyimpanan gambar tidak dapat dibuat.'
                );
            }
        }

        $extension = $allowedMimeTypes[$mimeType];

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;

        $target = $directory . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $target)) {
            throw new RuntimeException(
                'Gambar gagal disimpan.'
            );
        }

        return $filename;
    }

    private function deleteProductImage(string $filename): void
    {
        $filename = basename($filename);

        $systemImages = [
            'bghal.jpg',
            'bgudang.png',
            'logo.png',
            'cumi.png',
            'kakap.png',
            'tuna.png',
            'udang.png',
        ];

        if (
            in_array($filename, $systemImages, true) ||
            !preg_match(
                '/^[a-f0-9]{32}\.(jpg|png|webp)$/i',
                $filename
            )
        ) {
            return;
        }

        $path = dirname(__DIR__, 2)
            . '/public/assets/images/'
            . $filename;

        if (is_file($path)) {
            unlink($path);
        }
    }
}
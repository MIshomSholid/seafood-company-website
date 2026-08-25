<?php

require_once __DIR__ . '/../models/Inquiry.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/security.php';

class InquiryController
{
    private Inquiry $inquiryModel;
    private Product $productModel;
    private User $userModel;

    public function __construct()
    {
        $this->inquiryModel = new Inquiry();
        $this->productModel = new Product();
        $this->userModel = new User();
    }

    /**
     * Store inquiry via AJAX or standard form submission
     */
    public function store(): void
    {
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (isset($_SERVER['CONTENT_TYPE']) && str_contains($_SERVER['CONTENT_TYPE'], 'application/json'))
            || (isset($_POST['is_ajax']) && $_POST['is_ajax'] === '1');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if ($isAjax) {
                http_response_code(405);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Metode tidak diizinkan.']);
                exit;
            }
            header('Location: ?route=home#kontak');
            exit;
        }

        $userId = isset($_SESSION['user_id']) ? (int) $_SESSION['user_id'] : null;
        $currentUser = $userId ? $this->userModel->findById($userId) : null;

        // Validate required fields
        $name = trim($_POST['name'] ?? ($currentUser['name'] ?? ''));
        $phone = trim($_POST['phone'] ?? ($_POST['whatsapp'] ?? ($currentUser['phone'] ?? '')));
        $productName = trim($_POST['product_name'] ?? '');
        $productId = (int) ($_POST['product_id'] ?? 0);
        $quantity = trim($_POST['quantity'] ?? '');
        if ($quantity !== '' && preg_match('/^\d+(?:[.,]\d+)?$/', $quantity)) {
            $quantity .= ' kg';
        }
        $company = trim($_POST['company'] ?? ($currentUser['company'] ?? ''));
        $email = trim($_POST['email'] ?? ($currentUser['email'] ?? ''));
        $message = trim($_POST['message'] ?? ($_POST['notes'] ?? ''));

        if ($name === '' || $phone === '') {
            if ($isAjax) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Nama dan nomor WhatsApp wajib diisi.']);
                exit;
            }
            $_SESSION['error'] = 'Nama dan nomor WhatsApp wajib diisi.';
            header('Location: ?route=home#kontak');
            exit;
        }

        // If product ID is not set but product name is given, look it up
        if ($productId <= 0 && $productName !== '') {
            $allProducts = $this->productModel->getAll();
            foreach ($allProducts as $p) {
                if (strcasecmp($p['name'], $productName) === 0 || str_contains(strtolower($p['name']), strtolower($productName))) {
                    $productId = (int) $p['id'];
                    break;
                }
            }
        }

        $fullMessage = "Permintaan Pasokan: " . ($productName ?: 'Seafood');
        if ($quantity !== '') $fullMessage .= " ({$quantity})";
        if ($message !== '') $fullMessage .= "\nCatatan: " . $message;

        $inquiry = $this->inquiryModel->create([
            'user_id' => $userId,
            'name' => $name,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'type' => 'quotation',
            'product_id' => ($productId > 0) ? $productId : null,
            'quantity' => $quantity,
            'message' => $fullMessage,
            'status' => 'new',
            'priority' => 'normal',
        ]);

        if (!$inquiry) {
            if ($isAjax) {
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Gagal menyimpan permintaan penawaran ke database.']);
                exit;
            }
            $_SESSION['error'] = 'Terjadi kendala saat menyimpan permintaan. Silakan coba lagi.';
            header('Location: ?route=home#kontak');
            exit;
        }

        // If user logged in and didn't have phone/company saved, update user profile
        if ($userId && $currentUser) {
            $updateUserData = [];
            if (empty($currentUser['phone']) && $phone !== '') $updateUserData['phone'] = $phone;
            if (empty($currentUser['company']) && $company !== '') $updateUserData['company'] = $company;
            if (!empty($updateUserData)) {
                $this->userModel->updateProfile($userId, array_merge($currentUser, $updateUserData));
            }
        }

        if ($isAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'reference_number' => $inquiry['reference_number'],
                'inquiry' => $inquiry,
                'message' => 'Permintaan penawaran berhasil dikirim.',
            ]);
            exit;
        }

        $_SESSION['success'] = "Permintaan penawaran berhasil dikirim dengan Nomor Referensi: {$inquiry['reference_number']}";
        header('Location: ?route=home#kontak');
        exit;
    }

    /**
     * Admin: List all inquiries
     */
    public function adminIndex(): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        $status = $_GET['status'] ?? 'all';
        $priority = $_GET['priority'] ?? 'all';
        $search = trim($_GET['q'] ?? '');

        $inquiries = $this->inquiryModel->getAll($status, $priority, $search);
        $stats = $this->inquiryModel->getStats();

        require_once __DIR__ . '/../views/admin/inquiries/index.php';
    }

    /**
     * Admin: View single inquiry detail
     */
    public function adminShow(int $id): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        $inquiry = $this->inquiryModel->getById($id);

        if (!$inquiry) {
            $_SESSION['error'] = 'Inquiry tidak ditemukan.';
            header('Location: ?route=admin/inquiries');
            exit;
        }

        require_once __DIR__ . '/../views/admin/inquiries/show.php';
    }

    /**
     * Admin: Update inquiry status/priority/note
     */
    public function adminUpdate(int $id): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: ?route=admin/inquiries/show&id={$id}");
            exit;
        }

        require_valid_csrf();

        $status = trim($_POST['status'] ?? 'new');
        $priority = trim($_POST['priority'] ?? 'normal');
        $adminNote = trim($_POST['admin_note'] ?? '');

        $success = $this->inquiryModel->update($id, [
            'status' => $status,
            'priority' => $priority,
            'admin_note' => $adminNote,
        ]);

        if ($success) {
            $_SESSION['success'] = 'Data inquiry berhasil diperbarui.';
        } else {
            $_SESSION['error'] = 'Gagal memperbarui data inquiry.';
        }

        header("Location: ?route=admin/inquiries/show&id={$id}");
        exit;
    }

    /**
     * Admin: Delete inquiry
     */
    public function adminDelete(int $id): void
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=admin/inquiries');
            exit;
        }

        require_valid_csrf();

        $this->inquiryModel->delete($id);
        $_SESSION['success'] = 'Inquiry berhasil dihapus.';
        header('Location: ?route=admin/inquiries');
        exit;
    }
}
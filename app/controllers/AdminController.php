<?php

require_once __DIR__ . '/../models/Admin.php';

class AdminController
{
    /**
     * Menampilkan halaman login admin.
     */
    public function login()
    {
        if (isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/dashboard');
            exit;
        }

        require_once __DIR__ . '/../views/admin/login.php';
    }


    /**
     * Memproses login admin.
     */
    public function authenticate()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?route=admin/login');
            exit;
        }

        require_valid_csrf();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($username === '' || $password === '') {
            $_SESSION['error'] = 'Username dan password wajib diisi.';
            header('Location: ?route=admin/login');
            exit;
        }

        $adminModel = new Admin();

        $admin = $adminModel->findByUsername($username);

        if (!$admin || !password_verify($password, $admin['password'])) {
            $_SESSION['error'] = 'Username atau password salah.';
            header('Location: ?route=admin/login');
            exit;
        }

        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_name'] = $admin['name'];

        header('Location: ?route=admin/dashboard');
        exit;
    }


    /**
     * Menampilkan dashboard admin.
     */
    public function dashboard()
    {
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ?route=admin/login');
            exit;
        }

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }


    /**
     * Logout admin.
     */
    public function logout()
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }

        session_destroy();

        header('Location: ?route=admin/login');
        exit;
    }
}
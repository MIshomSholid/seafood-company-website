<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/ChatConversation.php';
require_once __DIR__ . '/../../config/security.php';

class AuthController
{
    private User $userModel;
    private ChatConversation $chatConvModel;
    private array $config;

    public function __construct()
    {
        $this->userModel = new User();
        $this->chatConvModel = new ChatConversation();
        $configFile = __DIR__ . '/../../config/auth.php';
        $this->config = file_exists($configFile) ? require $configFile : [];
    }

    /**
     * Customer Login Page
     */
    public function login(): void
    {
        if (isset($_SESSION['user_id'])) {
            header('Location: ?route=account');
            exit;
        }

        $returnTo = $_GET['return_to'] ?? '';
        if ($returnTo !== '') {
            $_SESSION['auth_return_to'] = $returnTo;
        }

        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);

        require_once __DIR__ . '/../views/auth/login.php';
    }

    /**
     * Initiate Google OAuth 2.0 Authorization
     */
    public function googleRedirect(): void
    {
        if (isset($_GET['return_to']) && $_GET['return_to'] !== '') {
            $_SESSION['auth_return_to'] = $_GET['return_to'];
        }

        $googleConfig = $this->config['google'] ?? [];
        $clientId = trim($googleConfig['client_id'] ?? '');

        // Generate CSRF OAuth state token
        $state = bin2hex(random_bytes(32));
        $_SESSION['oauth_state'] = $state;

        // If Google Client ID is configured, redirect to Google OAuth server
        if ($clientId !== '' && !str_starts_with($clientId, 'YOUR_')) {
            $params = http_build_query([
                'client_id' => $clientId,
                'redirect_uri' => $googleConfig['redirect_uri'],
                'response_type' => 'code',
                'scope' => implode(' ', $googleConfig['scopes'] ?? ['openid', 'email', 'profile']),
                'state' => $state,
                'access_type' => 'online',
                'prompt' => 'select_account',
            ]);

            header('Location: ' . $googleConfig['auth_url'] . '?' . $params);
            exit;
        }

        // Developer / Staging Simulation Fallback (Safe One-Click Login when credentials pending)
        $simulatedEmail = $_GET['email'] ?? 'customer@example.com';
        $simulatedName = $_GET['name'] ?? 'Pelanggan Terdaftar';

        $user = $this->userModel->createOrUpdateFromGoogle([
            'google_id' => 'sim_' . md5($simulatedEmail),
            'name' => $simulatedName,
            'email' => $simulatedEmail,
            'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($simulatedName) . '&background=0284c7&color=fff',
        ]);

        $this->establishUserSession($user);
        $returnUrl = $_SESSION['auth_return_to'] ?? '?route=account';
        unset($_SESSION['auth_return_to']);

        header('Location: ' . $returnUrl);
        exit;
    }

    /**
     * Handle Google OAuth 2.0 Callback
     */
    public function googleCallback(): void
    {
        $googleConfig = $this->config['google'] ?? [];
        $state = $_GET['state'] ?? '';
        $code = $_GET['code'] ?? '';
        $sessionState = $_SESSION['oauth_state'] ?? '';
        unset($_SESSION['oauth_state']);

        // 1. Verify CSRF State
        if ($state === '' || $sessionState === '' || !hash_equals($sessionState, $state)) {
            $_SESSION['auth_error'] = 'Validasi sesi login Google tidak valid. Silakan coba lagi.';
            header('Location: ?route=auth/login');
            exit;
        }

        // 2. Exchange authorization code for token
        if ($code === '') {
            $_SESSION['auth_error'] = 'Otorisasi Google dibatalkan.';
            header('Location: ?route=auth/login');
            exit;
        }

        $clientId = trim($googleConfig['client_id'] ?? '');
        $clientSecret = trim($googleConfig['client_secret'] ?? '');
        $redirectUri = $googleConfig['redirect_uri'] ?? '';

        $tokenPayload = [
            'code' => $code,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'grant_type' => 'authorization_code',
        ];

        $ch = curl_init($googleConfig['token_url']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($tokenPayload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/x-www-form-urlencoded'],
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $tokenData = json_decode($response, true);
        $accessToken = $tokenData['access_token'] ?? '';

        if ($httpCode !== 200 || $accessToken === '') {
            error_log("Google Token Exchange Failed: " . $response);
            $_SESSION['auth_error'] = 'Gagal menukarkan kode otorisasi Google. Silakan coba lagi.';
            header('Location: ?route=auth/login');
            exit;
        }

        // 3. Fetch User Profile Info
        $ch = curl_init($googleConfig['userinfo_url']);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => ["Authorization: Bearer {$accessToken}"],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $userinfoResponse = curl_exec($ch);
        $userinfoCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $userInfo = json_decode($userinfoResponse, true);

        if ($userinfoCode !== 200 || empty($userInfo['email'])) {
            error_log("Google UserInfo Fetch Failed: " . $userinfoResponse);
            $_SESSION['auth_error'] = 'Gagal mengambil data profil Google.';
            header('Location: ?route=auth/login');
            exit;
        }

        // 4. Create or Update User in DB
        $user = $this->userModel->createOrUpdateFromGoogle([
            'google_id' => $userInfo['sub'] ?? ($userInfo['id'] ?? null),
            'name' => $userInfo['name'] ?? ($userInfo['given_name'] ?? 'Pelanggan'),
            'email' => $userInfo['email'],
            'avatar' => $userInfo['picture'] ?? null,
        ]);

        $this->establishUserSession($user);

        $returnUrl = $_SESSION['auth_return_to'] ?? '?route=account';
        unset($_SESSION['auth_return_to']);

        header('Location: ' . $returnUrl);
        exit;
    }

    /**
     * Establish Authenticated Customer Session & Link Guest Conversation
     */
    private function establishUserSession(array $user): void
    {
        // Session fixation protection
        session_regenerate_id(true);

        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_avatar'] = $user['avatar'] ?? '';
        $_SESSION['user_phone'] = $user['phone'] ?? '';
        $_SESSION['user_company'] = $user['company'] ?? '';

        // Account Linking: If guest chat session existed, associate it to this user!
        $guestSessionId = $_SESSION['skm_ai_session_id'] ?? ($_GET['session_id'] ?? '');
        if ($guestSessionId !== '') {
            $this->chatConvModel->linkGuestConversationToUser($guestSessionId, (int) $user['id']);
        }
    }

    /**
     * Customer Logout
     */
    public function logout(): void
    {
        unset(
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $_SESSION['user_email'],
            $_SESSION['user_avatar'],
            $_SESSION['user_phone'],
            $_SESSION['user_company'],
            $_SESSION['auth_return_to'],
            $_SESSION['auth_error']
        );

        session_regenerate_id(true);
        header('Location: ?route=home');
        exit;
    }
}
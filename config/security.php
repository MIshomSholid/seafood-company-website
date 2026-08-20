<?php

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8')
        . '">';
}

function verify_csrf_token(): bool
{
    $submittedToken = $_POST['csrf_token'] ?? '';
    $sessionToken = $_SESSION['csrf_token'] ?? '';

    return is_string($submittedToken)
        && is_string($sessionToken)
        && $submittedToken !== ''
        && hash_equals($sessionToken, $submittedToken);
}

function require_valid_csrf(): void
{
    if (!verify_csrf_token()) {
        http_response_code(419);
        echo 'Permintaan tidak valid. Silakan coba lagi.';
        exit;
    }
}
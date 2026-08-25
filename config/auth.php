<?php

return [
    'google' => [
        'client_id' => getenv('GOOGLE_CLIENT_ID') ?: ($_ENV['GOOGLE_CLIENT_ID'] ?? ''),
        'client_secret' => getenv('GOOGLE_CLIENT_SECRET') ?: ($_ENV['GOOGLE_CLIENT_SECRET'] ?? ''),
        'redirect_uri' => getenv('GOOGLE_REDIRECT_URI') ?: ($_ENV['GOOGLE_REDIRECT_URI'] ?? (
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') .
            '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') .
            (rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? ''), '/\\')) .
            '/?route=auth/google/callback'
        )),
        'auth_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
        'token_url' => 'https://oauth2.googleapis.com/token',
        'userinfo_url' => 'https://www.googleapis.com/oauth2/v3/userinfo',
        'scopes' => ['openid', 'email', 'profile'],
    ],
    'session' => [
        'customer_session_key' => 'user_id',
        'customer_name_key' => 'user_name',
        'customer_email_key' => 'user_email',
        'customer_avatar_key' => 'user_avatar',
    ],
    'rate_limit' => [
        'guest_max_messages_per_hour' => 30,
        'user_max_messages_per_hour' => 120,
    ],
];
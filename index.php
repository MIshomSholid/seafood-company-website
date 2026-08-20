<?php

session_set_cookie_params([
	'httponly' => true,
	'samesite' => 'Lax',
]);
session_start();

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/security.php';
require_once __DIR__ . '/routes/web.php';
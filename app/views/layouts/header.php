<?php
$currentRoute = $_GET['route'] ?? 'home';
$isHome = ($currentRoute === 'home' || empty($currentRoute));
$navPrefix = $isHome ? '' : '?route=home';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="PT Samudra Kencana Mina - Perusahaan pengolahan seafood dan penyedia fresh frozen food berkualitas tinggi berbasis di Sidoarjo, Jawa Timur.">
    <meta name="keywords" content="Samudra Kencana Mina, fresh frozen food, seafood indonesia, tuna fillet, kakap merah, sidoarjo, cold storage">
    <meta name="author" content="PT Samudra Kencana Mina">

    <title>PT Samudra Kencana Mina | Fresh Frozen Food</title>
    <link rel="icon" type="image/png" href="public/assets/images/logo.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body>

    <!-- Top Scroll Progress Bar -->
    <div id="scroll-progress-bar" class="scroll-progress-bar" aria-hidden="true"></div>

    <!-- Smart Sticky Navbar -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top custom-navbar" id="mainNavbar" aria-label="Navigasi Utama">
            <div class="container">

                <a class="navbar-brand d-flex align-items-center" href="?route=home" aria-label="PT Samudra Kencana Mina Beranda">
                    <img src="public/assets/images/logo.png" alt="PT Samudra Kencana Mina" class="navbar-brand-logo" width="38" height="38">
                    <div class="d-flex flex-column ms-2 brand-text-wrapper">
                        <span class="brand-title">PT Samudra Kencana Mina</span>
                        <span class="brand-subtitle">Fresh Frozen Food</span>
                    </div>
                </a>

                <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Buka Menu Navigasi">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                        <li class="nav-item">
                            <a class="nav-link <?= $isHome ? 'active' : '' ?>" href="<?= $navPrefix ?>#beranda">
                                Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $navPrefix ?>#tentang">
                                Tentang Kami
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentRoute === 'products' || $currentRoute === 'product/show') ? 'active' : '' ?>" href="<?= $navPrefix ?>#produk">
                                Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= ($currentRoute === 'comments') ? 'active' : '' ?>" href="<?= $navPrefix ?>#forum">
                                Forum
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $navPrefix ?>#kontak">
                                Kontak
                            </a>
                        </li>
                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            <button type="button" class="btn btn-contact-cta" data-bs-toggle="modal" data-bs-target="#rfqModal">
                                <i class="fas fa-file-invoice me-1"></i> Request Penawaran
                            </button>
                        </li>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item dropdown ms-lg-2 mt-2 mt-lg-0">
                                <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-white bg-dark bg-opacity-50 px-3 py-1 rounded-pill border border-secondary border-opacity-50" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php if (!empty($_SESSION['user_avatar'])): ?>
                                        <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" alt="Avatar" class="rounded-circle" width="24" height="24" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($_SESSION['user_name'] ?? 'User') ?>&background=0284c7&color=fff'">
                                    <?php else: ?>
                                        <i class="fas fa-user-circle fs-5 text-info"></i>
                                    <?php endif; ?>
                                    <span class="small fw-semibold"><?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Akun')[0]) ?></span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                                    <li class="px-3 py-2 border-bottom">
                                        <div class="fw-bold small text-dark"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></div>
                                        <div class="text-muted" style="font-size: 0.75rem;"><?= htmlspecialchars($_SESSION['user_email'] ?? '') ?></div>
                                    </li>
                                    <li><a class="dropdown-item py-2 small" href="?route=account"><i class="fas fa-user text-primary me-2"></i> Dashboard Akun</a></li>
                                    <li><a class="dropdown-item py-2 small" href="?route=account"><i class="fas fa-file-invoice text-info me-2"></i> Status Penawaran</a></li>
                                    <li><hr class="dropdown-divider my-1"></li>
                                    <li><a class="dropdown-item py-2 small text-danger" href="?route=auth/logout"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                                <a href="?route=auth/login" class="btn btn-outline-light btn-sm rounded-pill px-3 py-1 small fw-semibold">
                                    <i class="fab fa-google text-warning me-1"></i> Masuk
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>

            </div>
        </nav>
    </header>


<?php
require_once __DIR__ . '/../../../config/security.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | PT Samudra Kencana Mina</title>
    <link rel="icon" type="image/png" href="public/assets/images/logo.png">

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="public/css/style.css">
</head>

<body style="background: linear-gradient(135deg, var(--skm-navy-950) 0%, var(--skm-navy-900) 50%, #0c2b57 100%); min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5 col-xl-4">

                <div class="card border-0 shadow-2xl rounded-4 overflow-hidden" style="background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(16px);">
                    <div class="card-body p-4 p-sm-5">

                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="d-inline-flex p-3 rounded-4 mb-3" style="background: var(--skm-blue-50); border: 1px solid var(--skm-blue-100);">
                                <img src="public/assets/images/logo.png" alt="PT Samudra Kencana Mina" style="width: 48px; height: 48px; object-fit: contain;">
                            </div>

                            <h3 class="fw-bold text-dark mb-1">Portal Administrator</h3>
                            <p class="text-muted small mb-0">PT Samudra Kencana Mina</p>
                        </div>

                        <!-- Error Message -->
                        <?php if (!empty($_SESSION['error'])): ?>
                            <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 rounded-3 mb-4" role="alert">
                                <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                                <div class="small fw-semibold"><?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?></div>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <!-- Login Form -->
                        <form method="POST" action="?route=admin/authenticate">
                            <?= csrf_field() ?>

                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="skm-form-label">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-user"></i></span>
                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        class="form-control skm-form-control border-start-0"
                                        placeholder="Masukkan username"
                                        required
                                        autocomplete="username"
                                    >
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label for="password" class="skm-form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-lock"></i></span>
                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control skm-form-control border-start-0"
                                        placeholder="Masukkan password"
                                        required
                                        autocomplete="current-password"
                                    >
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="skm-btn-primary w-100 py-3 mb-3">
                                <i class="fas fa-sign-in-alt me-1"></i> Masuk ke Panel
                            </button>

                            <!-- Back Link -->
                            <div class="text-center">
                                <a href="?route=home" class="text-muted text-decoration-none small">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Website Utama
                                </a>
                            </div>

                        </form>

                    </div>
                </div>

                <p class="text-center text-white-50 small mt-4 mb-0">
                    &copy; <?= date('Y') ?> PT Samudra Kencana Mina.
                </p>

            </div>
        </div>
    </div>

</body>
</html>
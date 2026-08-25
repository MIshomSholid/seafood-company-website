<?php
require_once __DIR__ . '/../layouts/header.php';
$escape = static fn ($val): string => htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
?>

<main class="py-5 bg-light" style="min-height: 80vh;">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white text-center py-4 position-relative" style="background: linear-gradient(135deg, #071326 0%, #0c2044 100%) !important;">
                        <div class="mb-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-primary" style="width: 48px; height: 48px; font-size: 1.3rem;">
                                <i class="fas fa-user-circle"></i>
                            </span>
                        </div>
                        <h4 class="fw-bold mb-1">Masuk ke Akun Customer</h4>
                        <p class="small text-info mb-0">PT Samudra Kencana Mina &bull; Portal Pelanggan</p>
                    </div>

                    <div class="card-body p-4 p-md-5">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger rounded-3 small py-2 d-flex align-items-center gap-2 mb-4" role="alert">
                                <i class="fas fa-exclamation-circle flex-shrink-0"></i>
                                <div><?= $escape($error) ?></div>
                            </div>
                        <?php endif; ?>

                        <p class="text-secondary small mb-4 text-center">
                            Masuk dengan akun Google Anda untuk menyimpan riwayat percakapan AI secara permanen, mengajukan permintaan penawaran (RFQ), dan memantau status pesanan pasokan seafood Anda.
                        </p>

                        <!-- Google Login Button -->
                        <div class="d-grid mb-4">
                            <a href="?route=auth/google<?= !empty($_SESSION['auth_return_to']) ? '&return_to=' . urlencode($_SESSION['auth_return_to']) : '' ?>" class="btn btn-outline-dark btn-lg rounded-pill py-3 fw-bold d-flex align-items-center justify-content-center gap-3 shadow-sm hover-elevate">
                                <svg width="22" height="22" viewBox="0 0 48 48">
                                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                                    <path fill="none" d="M0 0h48v48H0z"/>
                                </svg>
                                <span>Lanjutkan dengan Google</span>
                            </a>
                        </div>

                        <!-- Security & Benefits Badges -->
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold small mb-2 text-dark"><i class="fas fa-shield-alt text-primary me-1"></i> Keuntungan Masuk Akun:</h6>
                            <ul class="small text-muted mb-0 ps-3">
                                <li>Riwayat percakapan SKM Assistant tersimpan aman</li>
                                <li>Pemantauan status Permintaan Penawaran (RFQ) real-time</li>
                                <li>Pengisian otomatis data customer saat meminta penawaran</li>
                                <li>Akses langsung kontak prioritas tim sales SKM</li>
                            </ul>
                        </div>

                        <div class="text-center mt-4">
                            <a href="?route=home" class="text-decoration-none text-muted small">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
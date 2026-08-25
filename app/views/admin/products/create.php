<?php
require_once __DIR__ . '/../../../../config/security.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ?route=admin/login');
    exit;
}
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru | Admin Samudra Kencana Mina</title>
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

<body class="skm-admin-body">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-expand-lg skm-admin-navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="?route=admin/dashboard">
                <img src="public/assets/images/logo.png" alt="Logo" style="width: 36px; height: 36px; background: white; border-radius: 8px; padding: 2px;">
                <div>
                    <span class="fw-bold fs-6">Admin Panel</span>
                    <small class="d-block text-white-50" style="font-size: 0.7rem;">PT Samudra Kencana Mina</small>
                </div>
            </a>

            <div class="d-flex align-items-center gap-3">
                <div class="d-flex align-items-center text-white small gap-2">
                    <div class="skm-avatar-initial" style="width: 32px; height: 32px; font-size: 0.8rem; background: var(--skm-blue-600);">
                        <?= $escape(mb_substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="d-none d-sm-inline fw-semibold"><?= $escape($_SESSION['admin_name'] ?? 'Administrator') ?></span>
                </div>

                <a href="?route=admin/products" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-boxes me-1"></i> Data Produk
                </a>

                <a href="?route=admin/logout" class="btn btn-danger btn-sm rounded-pill px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <!-- Header -->
                <div class="mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-1">
                            <li class="breadcrumb-item"><a href="?route=admin/dashboard" class="text-decoration-none">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="?route=admin/products" class="text-decoration-none">Produk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Produk</li>
                        </ol>
                    </nav>
                    <h1 class="h2 fw-bold text-dark mb-1">Tambah Produk Seafood Baru</h1>
                    <p class="text-muted small mb-0">Isi formulir berikut untuk mendaftarkan komoditas seafood baru ke dalam katalog.</p>
                </div>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger rounded-3 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                        <i class="fas fa-exclamation-circle fs-5 flex-shrink-0"></i>
                        <div><?= $escape($_SESSION['error']) ?></div>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <!-- Form Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4 p-sm-5">

                        <form method="POST" action="?route=admin/products/store" enctype="multipart/form-data">
                            <?= csrf_field() ?>

                            <!-- Nama Produk -->
                            <div class="mb-4">
                                <label for="name" class="skm-form-label">
                                    Nama Produk Seafood <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control skm-form-control"
                                    placeholder="Contoh: Tuna Fillet Yellowfin / Kakap Merah Segar"
                                    required
                                    maxlength="255"
                                >
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-4">
                                <label for="description" class="skm-form-label">
                                    Deskripsi & Informasi Kualitas <span class="text-danger">*</span>
                                </label>
                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control skm-form-control"
                                    rows="5"
                                    placeholder="Jelaskan kualitas, tekstur, potongan, rekomendasi penyajian, dan standar penyimpanan produk..."
                                    required
                                ></textarea>
                            </div>

                            <!-- Stok -->
                            <div class="mb-4">
                                <label for="stock" class="skm-form-label">
                                    Stok Produk (kg) <span class="text-danger">*</span>
                                </label>
                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    class="form-control skm-form-control"
                                    placeholder="0"
                                    min="0"
                                    value="0"
                                    required
                                >
                                <small class="text-muted d-block mt-1">Masukkan jumlah stok dalam kilogram (kg).</small>
                            </div>

                            <!-- Gambar -->
                            <div class="mb-4">
                                <label for="image" class="skm-form-label">
                                    Foto / Gambar Produk
                                </label>
                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    class="form-control skm-form-control"
                                    accept="image/jpeg,image/png,image/webp"
                                >
                                <div class="form-text mt-2 text-muted small">
                                    Format yang didukung: JPG, PNG, WEBP. Ukuran maksimal 2 MB. Disarankan rasio 4:3 atau resolusi tajam.
                                </div>

                                <div id="preview-container" class="mt-3 d-none">
                                    <span class="small text-muted d-block mb-1">Pratinjau Foto:</span>
                                    <img id="image-preview" class="img-thumbnail rounded-3 shadow-sm" style="max-height: 220px; object-fit: cover;" alt="Preview gambar produk">
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 pt-3 border-top">
                                <a href="?route=admin/products" class="btn btn-outline-secondary rounded-pill px-4">
                                    <i class="fas fa-arrow-left me-1"></i> Batal
                                </a>

                                <button type="submit" class="skm-btn-primary px-5">
                                    <i class="fas fa-save"></i>
                                    <span>Simpan Produk</span>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('image').addEventListener('change', function (event) {
            const container = document.getElementById('preview-container');
            const preview = document.getElementById('image-preview');
            const file = event.target.files[0];
            if (!file) {
                container.classList.add('d-none');
                preview.removeAttribute('src');
                return;
            }
            preview.src = URL.createObjectURL(file);
            container.classList.remove('d-none');
        });
    </script>
</body>
</html>
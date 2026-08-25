<?php
require_once __DIR__ . '/../../../config/security.php';
require_once __DIR__ . '/../layouts/header.php';

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$productId = (int) ($product['id'] ?? 0);
$productName = $product['name'] ?? '';
$productDesc = $product['description'] ?? '';
$productStock = (int) ($product['stock'] ?? 0);
$productImage = !empty($product['image']) ? basename($product['image']) : '';
?>

<main class="skm-section-padding bg-light" style="min-height: 80vh; padding-top: 130px;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?route=home" class="text-decoration-none">Beranda</a></li>
                <li class="breadcrumb-item"><a href="?route=products" class="text-decoration-none">Produk</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $escape($productName) ?></li>
            </ol>
        </nav>

        <div class="card border-0 shadow-lg rounded-4 overflow-hidden mb-5">
            <div class="row g-0">

                <!-- Left Column: Product Visual Showcase -->
                <div class="col-lg-5 p-4 d-flex flex-column align-items-center justify-content-center bg-white border-end">
                    <div class="position-relative w-100 rounded-3 overflow-hidden shadow-sm" style="aspect-ratio: 4/3; background: #f8fafc;">
                        <?php if (!empty($productImage)): ?>
                            <img
                                src="public/assets/images/<?= $escape($productImage) ?>"
                                class="img-fluid w-100 h-100"
                                style="object-fit: cover;"
                                alt="<?= $escape($productName) ?>"
                                onerror="this.onerror=null; this.src='public/assets/images/logo.png';"
                            >
                        <?php else: ?>
                            <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
                                <i class="fas fa-fish" style="font-size: 5rem;"></i>
                            </div>
                        <?php endif; ?>

                        <span class="skm-product-badge">
                            Fresh Frozen
                        </span>
                    </div>

                    <div class="w-100 mt-4 p-3 bg-light rounded-3 border text-center">
                        <span class="text-muted small d-block mb-1">Status Ketersediaan Stok</span>
                        <?php if ($productStock > 0): ?>
                            <span class="badge bg-success px-3 py-2 fs-6">
                                <i class="fas fa-check-circle me-1"></i> Tersedia (<?= $productStock ?> kg)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary px-3 py-2 fs-6">
                                <i class="fas fa-times-circle me-1"></i> Stok Saat Ini Habis (0 kg)
                            </span>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right Column: Product Detail & Specs -->
                <div class="col-lg-7 p-4 p-md-5 bg-white">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mb-2">
                        <span class="skm-eyebrow mb-0">PT Samudra Kencana Mina</span>
                        <span class="text-muted small"><i class="fas fa-shield-alt text-primary me-1"></i> Mutu Terjamin</span>
                    </div>

                    <h1 class="h2 fw-bold text-dark mb-3"><?= $escape($productName) ?></h1>

                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2">Deskripsi Produk</h6>
                        <p class="text-secondary" style="line-height: 1.7;"><?= nl2br($escape($productDesc)) ?></p>
                    </div>

                    <!-- Specifications Table / Card -->
                    <div class="card bg-light border-0 rounded-3 p-3 mb-4">
                        <h6 class="fw-bold text-dark mb-3"><i class="fas fa-list-check text-primary me-2"></i>Informasi & Penanganan</h6>
                        <div class="row g-2 small text-secondary">
                            <div class="col-sm-6">
                                <div class="p-2 bg-white rounded border">
                                    <strong>Kategori Produk:</strong><br>
                                    <span>Fresh Frozen Seafood</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-2 bg-white rounded border">
                                    <strong>Penyimpanan:</strong><br>
                                    <span>Cold Storage / Freezer</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-2 bg-white rounded border">
                                    <strong>Kualitas Mutu:</strong><br>
                                    <span>Higienis & Terjaga</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="p-2 bg-white rounded border">
                                    <strong>Peruntukan:</strong><br>
                                    <span>Konsumsi & Usaha Kuliner</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions & Ratings -->
                    <div class="d-flex flex-wrap gap-3 align-items-center pt-2">
                        <a href="tel:+62318547202" class="btn btn-primary px-4 py-2 rounded-pill fw-semibold">
                            <i class="fas fa-phone-alt me-1"></i> Pesan / Konsultasi Pasokan
                        </a>
                        <a href="?route=products" class="btn btn-outline-secondary px-4 py-2 rounded-pill">
                            <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog
                        </a>
                    </div>

                    <!-- Inline Rating Form -->
                    <div class="border-top mt-4 pt-4">
                        <h6 class="fw-bold text-dark mb-2"><i class="fas fa-star text-warning me-1"></i> Beri Penilaian Produk</h6>
                        <form method="POST" action="?route=rating/store" class="row g-2 align-items-center">
                            <?= csrf_field() ?>
                            <input type="hidden" name="product_id" value="<?= $productId ?>">

                            <div class="col-sm-6">
                                <select name="rating" class="form-select" required aria-label="Pilih nilai rating">
                                    <option value="5" selected>5 - Sangat Baik (Sangat Puas)</option>
                                    <option value="4">4 - Baik (Puas)</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="2">2 - Kurang Baik</option>
                                    <option value="1">1 - Sangat Buruk</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-warning w-100 fw-semibold">
                                    <i class="fas fa-paper-plane me-1"></i> Kirim Rating
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>


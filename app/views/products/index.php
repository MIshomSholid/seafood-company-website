<?php
require_once __DIR__ . '/../layouts/header.php';
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>

<main class="skm-section-padding bg-light" style="min-height: 80vh; padding-top: 130px;">
    <div class="container">

        <!-- Breadcrumb & Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="?route=home" class="text-decoration-none">Beranda</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Katalog Produk</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-bold text-dark mb-0">Katalog Produk Seafood</h1>
            </div>

            <a href="?route=home#produk" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Beranda
            </a>
        </div>

        <!-- Product Search & Filter Toolbar -->
        <div class="skm-product-toolbar mb-4">
            <div class="row align-items-center g-3">
                <div class="col-lg-6 col-md-6">
                    <div class="skm-search-input-group">
                        <i class="fas fa-search"></i>
                        <input
                            type="text"
                            id="product-search"
                            class="skm-search-input"
                            placeholder="Cari produk seafood..."
                            aria-label="Cari produk"
                        >
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="skm-filter-pills justify-content-md-end">
                        <button type="button" class="skm-filter-btn active" data-filter="all">Semua</button>
                        <button type="button" class="skm-filter-btn" data-filter="tuna">Tuna</button>
                        <button type="button" class="skm-filter-btn" data-filter="kakap">Kakap</button>
                        <button type="button" class="skm-filter-btn" data-filter="udang">Udang</button>
                        <button type="button" class="skm-filter-btn" data-filter="cumi">Cumi</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="row g-4" id="product-grid-container">

            <?php if (empty($products)): ?>

                <div class="col-12">
                    <div class="card border-0 shadow-sm text-center py-5">
                        <div class="card-body">
                            <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem;"></i>
                            <h4 class="fw-bold">Belum Ada Produk</h4>
                            <p class="text-muted mb-0">Katalog produk saat ini sedang diperbarui.</p>
                        </div>
                    </div>
                </div>

            <?php else: ?>

                <?php foreach ($products as $product): ?>

                    <?php
                    $productId = (int) $product['id'];
                    $productName = $product['name'] ?? '';
                    $productDesc = $product['description'] ?? '';
                    $productStock = (int) ($product['stock'] ?? 0);
                    $productImage = !empty($product['image']) ? basename($product['image']) : '';

                    $categoryClass = 'all';
                    $lowerName = strtolower($productName);
                    if (str_contains($lowerName, 'tuna')) {
                        $categoryClass = 'tuna';
                    } elseif (str_contains($lowerName, 'kakap')) {
                        $categoryClass = 'kakap';
                    } elseif (str_contains($lowerName, 'udang')) {
                        $categoryClass = 'udang';
                    } elseif (str_contains($lowerName, 'cumi')) {
                        $categoryClass = 'cumi';
                    }
                    ?>

                    <div class="col-lg-4 col-md-6 skm-product-item"
                         data-name="<?= $escape($productName) ?>"
                         data-description="<?= $escape($productDesc) ?>"
                         data-category="<?= $escape($categoryClass) ?>">

                        <div class="skm-product-card">

                            <!-- Image & Badges -->
                            <div class="skm-product-img-wrapper">
                                <?php if (!empty($productImage)): ?>
                                    <img
                                        src="public/assets/images/<?= $escape($productImage) ?>"
                                        alt="<?= $escape($productName) ?>"
                                        loading="lazy"
                                        onerror="this.onerror=null; this.src='public/assets/images/logo.png';"
                                    >
                                <?php else: ?>
                                    <div class="skm-product-img-placeholder">
                                        <i class="fas fa-fish"></i>
                                    </div>
                                <?php endif; ?>

                                <span class="skm-product-badge">
                                    Fresh Frozen
                                </span>

                                <?php if ($productStock > 0): ?>
                                    <span class="skm-product-stock-badge skm-stock-available">
                                        <i class="fas fa-check-circle me-1"></i> Stok: <?= $productStock ?> kg
                                    </span>
                                <?php else: ?>
                                    <span class="skm-product-stock-badge skm-stock-empty">
                                        <i class="fas fa-times-circle me-1"></i> Stok Habis (0 kg)
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Body -->
                            <div class="skm-product-body">
                                <h3 class="skm-product-title">
                                    <?= $escape($productName) ?>
                                </h3>

                                <p class="skm-product-desc">
                                    <?= $escape($productDesc) ?>
                                </p>

                                <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                                    <span class="text-muted small">
                                        <i class="fas fa-shield-alt text-primary me-1"></i> Kualitas Premium
                                    </span>
                                    <a href="?route=product/show&id=<?= $productId ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                        Detail Produk <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

        <!-- Empty Search Notice -->
        <div id="product-empty-notice" class="card border-0 shadow-sm text-center py-5 d-none mt-4">
            <div class="card-body">
                <i class="fas fa-search text-muted mb-3" style="font-size: 2.5rem;"></i>
                <h5 class="fw-bold">Produk Tidak Ditemukan</h5>
                <p class="text-muted mb-0">Tidak ada produk yang cocok dengan pencarian Anda.</p>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
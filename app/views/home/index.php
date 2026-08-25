<?php
require_once __DIR__ . '/../../../config/security.php';
require_once __DIR__ . '/../layouts/header.php';

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>

<main>

    <!-- ======================================================================
         1. HERO SECTION (WITH SUBTLE OCEAN DEPTH & AMBIENT SHIMMER)
         ====================================================================== -->
    <section id="beranda" class="hero-section position-relative overflow-hidden">
        <div class="hero-ambient-glow" aria-hidden="true"></div>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center g-4 g-lg-5">

                <!-- Left Column: Copywriting, CTAs, & Trust Indicators -->
                <div class="col-lg-7 text-center text-lg-start skm-fade-up">
                    <span class="hero-eyebrow mb-3">
                        <i class="fas fa-snowflake me-1 text-info"></i> PT Samudra Kencana Mina &bull; Fresh Frozen Food
                    </span>

                    <h1 class="hero-title mt-2 mb-3">
                        Kualitas Seafood Segar, <br class="d-none d-sm-inline">
                        <span class="text-primary-gradient">Terjaga Sempurna</span> <br class="d-none d-sm-inline">
                        Hingga ke Tangan Anda.
                    </h1>

                    <p class="hero-lead mb-4">
                        Penyedia produk seafood olahan beku berkualitas tinggi dengan komitmen menjaga mutu higienis, sistem rantai dingin terstandar, dan kesegaran alami terbaik untuk konsumen dan mitra bisnis kuliner.
                    </p>

                    <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mb-4 hero-cta-group">
                        <a href="#produk" class="btn btn-hero-primary">
                            <i class="fas fa-box-open me-2"></i>
                            <span>Jelajahi Produk</span>
                            <i class="fas fa-arrow-right ms-2 btn-arrow-icon"></i>
                        </a>
                        <button type="button" class="btn btn-hero-outline" data-bs-toggle="modal" data-bs-target="#rfqModal">
                            <i class="fas fa-file-invoice me-2"></i>
                            <span>Request Penawaran</span>
                        </button>
                        <a href="#tentang" class="btn btn-hero-secondary">
                            <i class="fas fa-building me-2"></i>
                            <span>Tentang Kami</span>
                        </a>
                    </div>

                    <!-- Compact Trust Indicators -->
                    <div class="row g-3 pt-3 border-top border-white-10 text-start">
                        <div class="col-sm-4 col-12">
                            <div class="d-flex align-items-center gap-2 trust-badge-item">
                                <div class="trust-icon"><i class="fas fa-check-circle"></i></div>
                                <span class="trust-label">Standar Mutu Tinggi</span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="d-flex align-items-center gap-2 trust-badge-item">
                                <div class="trust-icon"><i class="fas fa-snowflake"></i></div>
                                <span class="trust-label">Fresh Frozen Food</span>
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <div class="d-flex align-items-center gap-2 trust-badge-item">
                                <div class="trust-icon"><i class="fas fa-shield-alt"></i></div>
                                <span class="trust-label">Higienis & Terpercaya</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Responsive Hero Visual Showcase Card -->
                <div class="col-lg-5 skm-fade-up">
                    <div class="hero-image-card shadow-lg position-relative rounded-4 overflow-hidden">
                        <img
                            src="public/assets/images/bghal.jpg"
                            alt="PT Samudra Kencana Mina Fresh Frozen Seafood"
                            class="img-fluid w-100 hero-main-img"
                            onerror="this.src='public/assets/images/logo.png'"
                        >
                        <div class="hero-image-overlay d-flex flex-column justify-content-end p-3 p-sm-4">
                            <div class="hero-image-badge d-inline-flex align-items-center gap-2 p-2 px-3 rounded-pill">
                                <i class="fas fa-award text-warning"></i>
                                <span class="small fw-bold text-white">Komitmen Mutu & Kesegaran Prima</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ======================================================================
         2. TENTANG KAMI (ABOUT US & STORY)
         ====================================================================== -->
    <section id="tentang" class="section-padding bg-white">
        <div class="container">

            <div class="section-header text-center mb-5 skm-fade-up">
                <span class="section-badge">Profil Perusahaan</span>
                <h2 class="section-title mt-2">Tentang PT Samudra Kencana Mina</h2>
                <p class="section-subtitle">Mengenal lebih dekat komitmen mutu dan visi perusahaan kami</p>
            </div>

            <div class="row align-items-center g-4 g-lg-5">

                <!-- Left Column: Image & Experience Badge -->
                <div class="col-lg-5 text-center skm-fade-up">
                    <div class="about-image-wrapper position-relative">
                        <img
                            src="public/assets/images/logo.png"
                            alt="PT Samudra Kencana Mina"
                            class="img-fluid about-logo-img"
                        >
                        <div class="about-exp-tag mt-3 d-inline-flex align-items-center gap-2 py-1 px-3 bg-white rounded-pill shadow-sm border">
                            <i class="fas fa-check-circle text-primary"></i>
                            <span class="fw-bold text-dark small">Pengalaman Lebih Dari 10 Tahun</span>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Authentic Story & Visi -->
                <div class="col-lg-7 skm-fade-up">
                    <h3 class="fw-bold text-dark mb-3">
                        Fresh Frozen Food — Keunggulan dalam Setiap Produk
                    </h3>

                    <p class="text-secondary mb-3" style="line-height: 1.8;">
                        PT Samudra Kencana Mina adalah perusahaan makanan beku terkemuka yang berkomitmen untuk menyediakan produk berkualitas tinggi dengan standar keamanan pangan yang ketat.
                    </p>

                    <p class="text-secondary mb-3" style="line-height: 1.8;">
                        Dengan pengalaman lebih dari 10 tahun dalam industri makanan beku, kami terus berinovasi untuk menghadirkan produk-produk terbaik bagi konsumen kami.
                    </p>

                    <!-- Authentic Vision Card -->
                    <div class="card bg-light border-0 rounded-4 p-3 p-md-4 mt-4 vision-card transition-hover">
                        <div class="d-flex align-items-start gap-3">
                            <div class="about-vision-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-1">Visi Perusahaan</h5>
                                <p class="text-muted mb-0 small" style="line-height: 1.7;">
                                    Menjadi pemimpin dalam industri makanan beku dengan mengutamakan kualitas, inovasi, dan kepuasan pelanggan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick RFQ Link from About -->
                    <div class="mt-4 pt-2 d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-outline-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#rfqModal">
                            <i class="fas fa-file-invoice me-1"></i> Konsultasi Kebutuhan Pasokan
                        </button>
                        <a href="#kontak" class="text-decoration-none fw-semibold small text-primary">
                            Hubungi Tim Kami <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ======================================================================
         3. PRODUK KAMI (CATALOG SHOWCASE & SMART QUICK VIEW)
         ====================================================================== -->
    <section id="produk" class="section-padding bg-light">
        <div class="container">

            <div class="section-header text-center mb-4 skm-fade-up">
                <span class="section-badge">Katalog Pilihan</span>
                <h2 class="section-title mt-2">Produk Seafood Berkualitas</h2>
                <p class="section-subtitle">Pilihan komoditas seafood olahan beku segar dengan standar mutu terjaga</p>
            </div>

            <!-- Search & Filter Controls -->
            <div class="product-toolbar card border-0 shadow-sm rounded-4 p-3 mb-4 skm-fade-up">
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input
                                type="text"
                                id="product-search"
                                class="form-control border-start-0"
                                placeholder="Cari nama produk seafood (contoh: Tuna, Kakap, Udang)..."
                                aria-label="Cari produk"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-wrap gap-2 justify-content-md-end filter-buttons">
                            <button type="button" class="btn btn-sm btn-filter active" data-filter="all">Semua</button>
                            <button type="button" class="btn btn-sm btn-filter" data-filter="tuna">Tuna</button>
                            <button type="button" class="btn btn-sm btn-filter" data-filter="kakap">Kakap</button>
                            <button type="button" class="btn btn-sm btn-filter" data-filter="udang">Udang</button>
                            <button type="button" class="btn btn-sm btn-filter" data-filter="cumi">Cumi</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            <div class="row g-4" id="product-grid-container">

                <?php if (empty($products)): ?>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm text-center py-5 rounded-4">
                            <div class="card-body">
                                <i class="fas fa-box-open text-muted mb-3 fs-1"></i>
                                <h4 class="fw-bold">Produk Belum Tersedia</h4>
                                <p class="text-muted mb-0">Saat ini data produk sedang dalam pembaruan oleh tim kami.</p>
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

                        $productRating = $ratings[$productId] ?? ['average' => 0, 'count' => 0];
                        $avgRating = round((float) ($productRating['average'] ?? 0), 1);
                        $ratingCount = (int) ($productRating['count'] ?? 0);

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

                        <div class="col-lg-6 product-grid-item skm-fade-up"
                             data-name="<?= $escape($productName) ?>"
                             data-description="<?= $escape($productDesc) ?>"
                             data-category="<?= $escape($categoryClass) ?>">

                            <div class="card product-card h-100 shadow-sm border-0 rounded-4 overflow-hidden transition-hover">
                                <div class="row g-0 h-100">

                                    <!-- Product Image -->
                                    <div class="col-md-5 product-card-img-col">
                                        <div class="product-img-holder h-100 position-relative overflow-hidden">
                                            <?php if (!empty($productImage)): ?>
                                                <img
                                                    src="public/assets/images/<?= $escape($productImage) ?>"
                                                    alt="<?= $escape($productName) ?>"
                                                    class="img-fluid w-100 h-100 product-img-fit"
                                                    loading="lazy"
                                                    onerror="this.onerror=null; this.src='public/assets/images/logo.png';"
                                                >
                                            <?php else: ?>
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted" style="min-height: 220px;">
                                                    <i class="fas fa-fish fs-1"></i>
                                                </div>
                                            <?php endif; ?>

                                            <span class="badge bg-primary position-absolute top-0 start-0 m-2 px-2 py-1 shadow-sm">
                                                Fresh Frozen
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Product Content -->
                                    <div class="col-md-7">
                                        <div class="card-body p-4 d-flex flex-column h-100">

                                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">
                                                <h4 class="card-title fw-bold text-dark mb-0 fs-5">
                                                    <?= $escape($productName) ?>
                                                </h4>

                                                <!-- Smart Stock Indicator -->
                                                <?php if ($productStock > 20): ?>
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                                        <i class="fas fa-check-circle me-1"></i> Stok: <?= $productStock ?> kg
                                                    </span>
                                                <?php elseif ($productStock > 0): ?>
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">
                                                        <i class="fas fa-exclamation-circle me-1"></i> Stok: <?= $productStock ?> kg
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                                        <i class="fas fa-times-circle me-1"></i> Stok Habis (0 kg)
                                                    </span>
                                                <?php endif; ?>
                                            </div>

                                            <p class="card-text text-secondary small mb-3 flex-grow-1" style="line-height: 1.6;">
                                                <?= $escape($productDesc) ?>
                                            </p>

                                            <!-- Rating Summary -->
                                            <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                                <div class="text-warning small">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i class="<?= $i <= round($avgRating) ? 'fas fa-star' : 'far fa-star' ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <span class="fw-bold small text-dark"><?= $avgRating > 0 ? $avgRating : '0.0' ?></span>
                                                <span class="text-muted small">(<?= $ratingCount ?> ulasan)</span>
                                            </div>

                                            <!-- Action Buttons: Quick View & Request RFQ & Rate -->
                                            <div class="d-flex flex-wrap gap-2 mt-auto">
                                                <button
                                                    type="button"
                                                    class="btn btn-outline-primary btn-sm rounded-pill px-3 py-1 flex-grow-1 btn-quick-view"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#productQuickViewModal"
                                                    data-id="<?= $productId ?>"
                                                    data-name="<?= $escape($productName) ?>"
                                                    data-description="<?= $escape($productDesc) ?>"
                                                    data-stock="<?= $productStock ?>"
                                                    data-image="<?= $escape($productImage) ?>"
                                                    data-rating="<?= $avgRating ?>"
                                                    data-count="<?= $ratingCount ?>"
                                                >
                                                    <i class="fas fa-eye me-1"></i> Detail
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-primary btn-sm rounded-pill px-3 py-1 btn-rfq-trigger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rfqModal"
                                                    data-product-id="<?= $productId ?>"
                                                    data-product-name="<?= $escape($productName) ?>"
                                                >
                                                    <i class="fas fa-file-invoice me-1"></i> Penawaran
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-outline-warning text-dark btn-sm rounded-pill px-2 py-1 btn-rate-modal-trigger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ratingModal"
                                                    data-product-id="<?= $productId ?>"
                                                    data-product-name="<?= $escape($productName) ?>"
                                                    title="Beri Nilai Produk"
                                                >
                                                    <i class="fas fa-star text-warning"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

            <!-- Empty Search Results Message -->
            <div id="product-empty-notice" class="card border-0 shadow-sm text-center py-5 d-none mt-4 rounded-4">
                <div class="card-body">
                    <i class="fas fa-search text-muted mb-3 fs-2"></i>
                    <h5 class="fw-bold">Produk Tidak Ditemukan</h5>
                    <p class="text-muted mb-3">Tidak ada produk yang cocok dengan kata kunci pencarian Anda.</p>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-4" id="resetSearchBtn">
                        <i class="fas fa-redo me-1"></i> Reset Pencarian
                    </button>
                </div>
            </div>

        </div>
    </section>


    <!-- ======================================================================
         4. FORUM DISKUSI (COMMUNITY & CUSTOMER VOICE)
         ====================================================================== -->
    <section id="forum" class="section-padding bg-white">
        <div class="container">

            <div class="section-header text-center mb-5 skm-fade-up">
                <span class="section-badge">Forum Pelanggan</span>
                <h2 class="section-title mt-2">Forum Diskusi & Ulasan</h2>
                <p class="section-subtitle">Sampaikan pendapat, ulasan mutu produk, atau masukan Anda secara terbuka</p>
            </div>

            <div class="row g-4">

                <!-- Left Column: Form Komentar -->
                <div class="col-lg-5 skm-fade-up">
                    <div class="card border-0 shadow-sm rounded-4 p-4 sticky-lg-top" style="top: 100px;">
                        <h5 class="fw-bold text-dark mb-2">
                            <i class="fas fa-edit text-primary me-2"></i> Tulis Ulasan / Saran
                        </h5>
                        <p class="text-muted small mb-3">Pendapat Anda sangat berharga bagi peningkatan mutu layanan kami.</p>

                        <form method="POST" action="?route=comment/store" id="commentForm">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="user-name" class="form-label small fw-semibold">Nama Lengkap</label>
                                <input
                                    type="text"
                                    id="user-name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Masukkan nama Anda"
                                    maxlength="255"
                                    required
                                >
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="user-comment" class="form-label small fw-semibold mb-0">Komentar / Masukan</label>
                                    <span class="text-muted small" id="commentCharCount" style="font-size: 0.75rem;">0 / 5000</span>
                                </div>
                                <textarea
                                    id="user-comment"
                                    name="comment"
                                    class="form-control"
                                    rows="4"
                                    placeholder="Tulis ulasan mengenai mutu produk, rasa, kesegaran, atau packing..."
                                    maxlength="5000"
                                    required
                                ></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold btn-submit-comment">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Ulasan
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Daftar Komentar -->
                <div class="col-lg-7 skm-fade-up">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-comments text-primary me-2"></i> Diskusi Terkini (<?= count($comments) ?>)
                        </h5>
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill small">
                            <i class="fas fa-shield-alt text-success me-1"></i> Ulasan Terverifikasi
                        </span>
                    </div>

                    <?php if (empty($comments)): ?>

                        <div class="card border-0 shadow-sm rounded-4 p-4 text-center">
                            <i class="fas fa-comment-dots text-muted mb-2 fs-2"></i>
                            <h6 class="fw-bold text-dark">Belum Ada Komentar</h6>
                            <p class="text-muted small mb-0">Jadilah yang pertama memberikan ulasan mutu produk kami.</p>
                        </div>

                    <?php else: ?>

                        <div class="d-flex flex-column gap-3" id="comment-list-container">
                            <?php foreach ($comments as $comment): ?>
                                <?php
                                $author = trim($comment['name'] ?? 'User');
                                if ($author === '') $author = 'User';
                                $initial = mb_substr($author, 0, 1, 'UTF-8');
                                ?>
                                <div class="card border-0 shadow-sm rounded-4 p-3 comment-card transition-hover">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <div class="comment-avatar">
                                            <?= $escape($initial) ?>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="fw-bold text-dark mb-0"><?= $escape($author) ?></h6>
                                            <?php if (!empty($comment['created_at'])): ?>
                                                <small class="text-muted" style="font-size: 0.75rem;">
                                                    <i class="far fa-clock me-1"></i>
                                                    <?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
                                                </small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="text-secondary small mb-0" style="line-height: 1.6;">
                                        <?= nl2br($escape($comment['comment'] ?? '')) ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                </div>

            </div>

        </div>
    </section>


    <!-- ======================================================================
         5. HUBUNGI KAMI (CONTACT & LOCATION)
         ====================================================================== -->
    <section id="kontak" class="section-padding bg-light">
        <div class="container">

            <div class="section-header text-center mb-5 skm-fade-up">
                <span class="section-badge">Informasi Kontak</span>
                <h2 class="section-title mt-2">Hubungi Kantor & Fasilitas Kami</h2>
                <p class="section-subtitle">Kami siap melayani kebutuhan informasi dan pasokan seafood beku Anda</p>
            </div>

            <div class="row g-4">

                <!-- Left Column: Contact Cards -->
                <div class="col-lg-6 skm-fade-up">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                        <h5 class="fw-bold text-dark mb-4">
                            <i class="fas fa-building text-primary me-2"></i> PT Samudra Kencana Mina
                        </h5>

                        <div class="d-flex flex-column gap-3">

                            <!-- Alamat -->
                            <div class="d-flex align-items-start gap-3 p-3 bg-white border rounded-3 transition-hover">
                                <div class="contact-card-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Alamat Kantor & Fasilitas</div>
                                    <div class="text-secondary small mt-1">
                                        Central Square E-31, JL Ahmad Yani, No. 41-43, Gedangan, Sidoarjo, Jawa Timur, 61254, Indonesia
                                    </div>
                                </div>
                            </div>

                            <!-- Telepon -->
                            <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-3 transition-hover">
                                <div class="contact-card-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Telepon Kantor</div>
                                    <div class="text-secondary small mt-1">
                                        <a href="tel:+62318547202" class="text-decoration-none text-secondary">
                                            +62 31 8547202
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-3 transition-hover">
                                <div class="contact-card-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Email Resmi</div>
                                    <div class="text-secondary small mt-1">
                                        <a href="mailto:info@skmseafood.com" class="text-decoration-none text-secondary">
                                            info@skmseafood.com
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Jam Operasional -->
                            <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-3 transition-hover">
                                <div class="contact-card-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Jam Operasional</div>
                                    <div class="text-secondary small mt-1">
                                        Senin - Jumat: 08:00 - 17:00 WIB
                                    </div>
                                </div>
                            </div>

                            <!-- Website -->
                            <div class="d-flex align-items-center gap-3 p-3 bg-white border rounded-3 transition-hover">
                                <div class="contact-card-icon">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">Website Resmi</div>
                                    <div class="text-secondary small mt-1">
                                        <a href="http://www.freshfrozenfoodskm.com" target="_blank" rel="noopener noreferrer" class="text-decoration-none text-primary">
                                            www.freshfrozenfoodskm.com
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Maps Box -->
                <div class="col-lg-6 skm-fade-up">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="min-height: 380px;">
                        <iframe
                            title="Lokasi PT Samudra Kencana Mina"
                            src="https://maps.google.com/maps?q=Central+Square+Gedangan+Sidoarjo+Ahmad+Yani&t=&z=15&ie=UTF8&iwloc=&output=embed"
                            style="border: 0; width: 100%; height: 100%; min-height: 380px;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                </div>

            </div>

        </div>
    </section>

</main>


<!-- ======================================================================
     MODAL 1: PRODUCT QUICK VIEW DRAWER/MODAL
     ====================================================================== -->
<div class="modal fade" id="productQuickViewModal" tabindex="-1" aria-labelledby="quickViewTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom bg-light px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1">Fresh Frozen Food</span>
                    <h5 class="modal-title fw-bold mb-0 text-dark" id="quickViewTitle">Detail Spesifikasi Produk</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-5 text-center">
                        <div class="rounded-4 overflow-hidden shadow-sm bg-light mb-3 position-relative" style="aspect-ratio: 4/3;">
                            <img id="qvProductImage" src="public/assets/images/logo.png" alt="Produk Seafood" class="img-fluid w-100 h-100" style="object-fit: cover;">
                        </div>
                        <div id="qvStockBadge" class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fs-6">
                            Stok Tersedia
                        </div>
                    </div>
                    <div class="col-md-7">
                        <span class="hero-eyebrow mb-2" style="font-size: 0.75rem;">PT Samudra Kencana Mina</span>
                        <h3 class="fw-bold text-dark mb-2" id="qvProductName">Nama Produk</h3>
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <div class="text-warning small" id="qvStars"></div>
                            <span class="fw-bold text-dark small" id="qvRatingAvg">0.0</span>
                            <span class="text-muted small" id="qvRatingCount">(0 ulasan)</span>
                        </div>
                        <p class="text-secondary small mb-4" id="qvProductDesc" style="line-height: 1.7;">
                            Deskripsi produk...
                        </p>

                        <div class="p-3 bg-light rounded-3 border mb-4">
                            <h6 class="fw-bold small text-dark mb-2"><i class="fas fa-shield-alt text-primary me-1"></i> Standar Mutu Produk</h6>
                            <ul class="list-unstyled mb-0 small text-muted">
                                <li><i class="fas fa-check text-success me-1"></i> Pengolahan beku higienis untuk menjaga mutu alami</li>
                                <li><i class="fas fa-check text-success me-1"></i> Cocok untuk kebutuhan retail, restoran, dan katering</li>
                            </ul>
                        </div>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary rounded-pill px-4 py-2 fw-semibold btn-qv-rfq" data-bs-dismiss="modal">
                                <i class="fas fa-file-invoice me-1"></i> Request Penawaran
                            </button>
                            <a href="#" target="_blank" rel="noopener noreferrer" class="btn btn-outline-success rounded-pill px-4 py-2 fw-semibold" id="qvWhatsAppBtn">
                                <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp
                            </a>
                            <button type="button" class="btn btn-light rounded-pill px-3 py-2" data-bs-dismiss="modal">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- ======================================================================
     MODAL 2: REQUEST FOR QUOTATION (RFQ) / PERMINTAAN PENAWARAN
     ====================================================================== -->
<div class="modal fade" id="rfqModal" tabindex="-1" aria-labelledby="rfqModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom bg-light px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="trust-icon"><i class="fas fa-file-invoice text-primary"></i></div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-dark" id="rfqModalTitle">Permintaan Penawaran Harga</h5>
                        <small class="text-muted">PT Samudra Kencana Mina &bull; Respon Cepat Pasokan Seafood</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body p-4" id="rfqModalBody">
                <p class="small text-muted mb-4">
                    Silakan isi formulir di bawah ini untuk mendapatkan informasi harga dan ketersediaan pasokan produk seafood olahan beku kami.
                </p>

                <form id="rfqForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="is_ajax" value="1">
                    <input type="hidden" name="product_id" id="rfqProductId" value="">

                    <div class="row g-3">
                        <!-- Product Selection -->
                        <div class="col-md-6">
                            <label for="rfqProductSelect" class="form-label small fw-semibold">Produk yang Diminati <span class="text-danger">*</span></label>
                            <select id="rfqProductSelect" name="product_name" class="form-select" required>
                                <option value="">-- Pilih Produk --</option>
                                <?php if (!empty($products)): ?>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= $escape($p['name']) ?>" data-id="<?= (int)$p['id'] ?>">
                                            <?= $escape($p['name']) ?> (Stok: <?= (int)$p['stock'] ?> kg)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <option value="Kebutuhan Campuran / Lainnya">Kebutuhan Campuran / Produk Lainnya</option>
                            </select>
                        </div>

                        <!-- Quantity Required -->
                        <div class="col-md-6">
                            <label for="rfqQuantity" class="form-label small fw-semibold">Estimasi Kebutuhan / Volume <span class="text-danger">*</span></label>
                            <input type="text" id="rfqQuantity" name="quantity" class="form-control" placeholder="Contoh: 30 kg, 100 kg, 1 ton" required>
                        </div>

                        <!-- Name -->
                        <div class="col-md-6">
                            <label for="rfqName" class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="rfqName" name="name" class="form-control" placeholder="Nama Anda / PIC" required>
                        </div>

                        <!-- Company / Business Name -->
                        <div class="col-md-6">
                            <label for="rfqCompany" class="form-label small fw-semibold">Nama Usaha / Perusahaan (Opsional)</label>
                            <input type="text" id="rfqCompany" name="company" class="form-control" placeholder="Nama Restoran / Katering / Retail">
                        </div>

                        <!-- WhatsApp / Phone -->
                        <div class="col-md-6">
                            <label for="rfqWhatsApp" class="form-label small fw-semibold">Nomor WhatsApp / HP <span class="text-danger">*</span></label>
                            <input type="tel" id="rfqWhatsApp" name="phone" class="form-control" placeholder="Contoh: 08123456789" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label for="rfqEmail" class="form-label small fw-semibold">Email (Opsional)</label>
                            <input type="email" id="rfqEmail" name="email" class="form-control" placeholder="alamat@email.com">
                        </div>

                        <!-- Notes -->
                        <div class="col-12">
                            <label for="rfqNotes" class="form-label small fw-semibold">Catatan Tambahan / Spesifikasi Pengiriman</label>
                            <textarea id="rfqNotes" name="message" class="form-control" rows="3" placeholder="Tuliskan spesifikasi potongan, jadwal pengiriman yang diinginkan, dll."></textarea>
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top d-flex flex-wrap gap-2 justify-content-end align-items-center">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success rounded-pill px-4 fw-semibold" id="btnSendRfqWhatsApp">
                            <i class="fab fa-whatsapp me-1"></i> Kirim via WhatsApp
                        </button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-semibold" id="btnSubmitRfqForm">
                            <i class="fas fa-paper-plane me-1"></i> Kirim Formulir
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ======================================================================
     MODAL 3: PRODUCT RATING MODAL (WITH INTERACTIVE STAR PICKER)
     ====================================================================== -->
<div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="ratingModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg overflow-hidden">
            <div class="modal-header border-bottom bg-light px-4 py-3">
                <h5 class="modal-title fw-bold mb-0" id="ratingModalTitle">
                    <i class="fas fa-star text-warning me-2"></i> Beri Penilaian Produk
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form method="POST" action="?route=rating/store" id="ratingSubmissionForm">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" id="modalRatingProductId" value="">
                <input type="hidden" name="rating" id="modalRatingScoreInput" value="5" required>

                <div class="modal-body text-center p-4">
                    <h5 class="fw-bold text-dark mb-1" id="modalRatingProductName">Nama Produk</h5>
                    <p class="text-muted small mb-4">Pilih tingkat kepuasan Anda terhadap mutu komoditas ini:</p>

                    <!-- Interactive Star Rating Picker UI -->
                    <div class="skm-star-picker-container mb-3" id="starPickerContainer">
                        <i class="fas fa-star skm-picker-star active" data-score="1" role="button" aria-label="1 Bintang"></i>
                        <i class="fas fa-star skm-picker-star active" data-score="2" role="button" aria-label="2 Bintang"></i>
                        <i class="fas fa-star skm-picker-star active" data-score="3" role="button" aria-label="3 Bintang"></i>
                        <i class="fas fa-star skm-picker-star active" data-score="4" role="button" aria-label="4 Bintang"></i>
                        <i class="fas fa-star skm-picker-star active" data-score="5" role="button" aria-label="5 Bintang"></i>
                    </div>
                    <div class="fw-bold text-primary fs-6" id="ratingFeedbackLabel">5 - Sangat Baik</div>
                </div>

                <div class="modal-footer border-top bg-light px-4 py-3">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold text-dark">
                        <i class="fas fa-paper-plane me-1"></i> Kirim Penilaian
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

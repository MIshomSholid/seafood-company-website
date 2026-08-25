<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ?route=admin/login');
    exit;
}
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$newInquiryCount = (int) ($inquiryStats['new'] ?? 0);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin | PT Samudra Kencana Mina</title>
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
                <a href="?route=admin/inquiries" class="btn btn-outline-info btn-sm rounded-pill px-3 position-relative">
                    <i class="fas fa-file-invoice me-1"></i> Inquiry
                    <?php if ($newInquiryCount > 0): ?>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?= $newInquiryCount ?>
                        </span>
                    <?php endif; ?>
                </a>

                <div class="d-flex align-items-center text-white small gap-2">
                    <div class="skm-avatar-initial" style="width: 32px; height: 32px; font-size: 0.8rem; background: var(--skm-blue-600);">
                        <?= $escape(mb_substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
                    </div>
                    <span class="d-none d-sm-inline fw-semibold"><?= $escape($_SESSION['admin_name'] ?? 'Administrator') ?></span>
                </div>

                <a href="?route=home" class="btn btn-outline-light btn-sm rounded-pill px-3" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i> Website
                </a>

                <a href="?route=admin/logout" class="btn btn-danger btn-sm rounded-pill px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-4 py-lg-5">

        <!-- Welcome Banner -->
        <div class="card border-0 rounded-4 p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--skm-navy-950) 0%, var(--skm-navy-900) 50%, #10376e 100%);">
            <div class="row align-items-center position-relative" style="z-index: 2;">
                <div class="col-lg-8">
                    <span class="skm-eyebrow skm-eyebrow-light mb-2">Panel Manajemen Konten & Inquiry</span>
                    <h1 class="h2 fw-bold text-white mb-2">
                        Selamat Datang, <?= $escape($_SESSION['admin_name'] ?? 'Administrator') ?>!
                    </h1>
                    <p class="text-white-50 mb-0" style="max-width: 600px;">
                        Kelola katalog produk seafood, tanggapi permintaan penawaran (inquiry), pantau log asisten AI, dan moderasi ulasan forum PT Samudra Kencana Mina.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-4 mt-lg-0 d-flex flex-column flex-sm-row gap-2 justify-content-lg-end">
                    <a href="?route=admin/inquiries" class="btn btn-info btn-lg rounded-pill px-4 shadow text-dark fw-bold">
                        <i class="fas fa-file-invoice me-1"></i> Lihat Inquiry (<?= (int) ($inquiryStats['total'] ?? 0) ?>)
                    </a>
                    <a href="?route=admin/products/create" class="btn btn-primary btn-lg rounded-pill px-4 shadow">
                        <i class="fas fa-plus-circle me-1"></i> Tambah Produk
                    </a>
                </div>
            </div>
        </div>

        <!-- Metric Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <span class="text-muted small d-block">Total Permintaan</span>
                    <h3 class="fw-bold text-dark mb-0"><?= (int) ($inquiryStats['total'] ?? 0) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-4">
                    <span class="text-muted small d-block">Inquiry Baru</span>
                    <h3 class="fw-bold text-primary mb-0">
                        <?= (int) ($inquiryStats['new'] ?? 0) ?>
                        <?php if ($newInquiryCount > 0): ?>
                            <span class="badge bg-danger rounded-pill fs-6 ms-1">Baru</span>
                        <?php endif; ?>
                    </h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                    <span class="text-muted small d-block">Sedang Diproses</span>
                    <h3 class="fw-bold text-warning mb-0"><?= (int) ($inquiryStats['processing'] ?? 0) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
                    <span class="text-muted small d-block">Selesai / Quoted</span>
                    <h3 class="fw-bold text-success mb-0"><?= (int) ($inquiryStats['completed'] ?? 0) ?></h3>
                </div>
            </div>
        </div>

        <!-- Dashboard Action Cards Grid -->
        <div class="row g-4 mb-5">

            <!-- Inquiries Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 transition-hover bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="skm-highlight-icon" style="background: var(--skm-blue-50); color: var(--skm-blue-600);">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <?php if ($newInquiryCount > 0): ?>
                            <span class="badge bg-danger rounded-pill px-2 py-1"><?= $newInquiryCount ?> Baru</span>
                        <?php else: ?>
                            <span class="badge bg-primary rounded-pill px-2 py-1">Inquiry</span>
                        <?php endif; ?>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">Permintaan Penawaran</h5>
                    <p class="text-muted small mb-4 flex-grow-1">
                        Kelola data permintaan pasokan, update status, dan hubungi pelanggan via WhatsApp.
                    </p>

                    <a href="?route=admin/inquiries" class="skm-btn-primary w-100 text-center">
                        <span>Buka Inquiry</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Products Management Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 transition-hover bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="skm-highlight-icon" style="background: var(--skm-blue-50); color: var(--skm-blue-600);">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <span class="badge bg-primary rounded-pill px-2 py-1"><?= (int)$productCount ?> Item</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">Katalog Produk</h5>
                    <p class="text-muted small mb-4 flex-grow-1">
                        Tambah, edit spesifikasi, update stok, dan foto produk olahan seafood beku.
                    </p>

                    <a href="?route=admin/products" class="btn btn-outline-primary w-100 rounded-pill py-2 fw-bold">
                        <i class="fas fa-boxes me-1"></i> Buka Produk
                    </a>
                </div>
            </div>

            <!-- AI Chat Log Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 transition-hover bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="skm-highlight-icon" style="background: var(--skm-teal-50); color: var(--skm-teal-700);">
                            <i class="fas fa-robot"></i>
                        </div>
                        <span class="badge bg-info text-dark rounded-pill px-2 py-1"><?= (int)$chatCount ?> Sesi</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">Log AI Assistant</h5>
                    <p class="text-muted small mb-4 flex-grow-1">
                        Pantau interaksi chat pengunjung dengan asisten AI dan riwayat pertanyaan produk.
                    </p>

                    <a href="?route=admin/chat" class="btn btn-outline-info w-100 rounded-pill py-2 fw-bold text-dark">
                        <i class="fas fa-comments me-1"></i> Buka Log AI
                    </a>
                </div>
            </div>

            <!-- Forum Management Card -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100 p-4 transition-hover bg-white">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="skm-highlight-icon" style="background: #FFFBEB; color: #D97706);">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <span class="badge bg-warning text-dark rounded-pill px-2 py-1">Forum</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">Forum Komentar</h5>
                    <p class="text-muted small mb-4 flex-grow-1">
                        Pantau ulasan kepuasan produk, masukan pelanggan, dan moderasi komentar.
                    </p>

                    <a href="?route=comments" class="btn btn-outline-warning text-dark w-100 rounded-pill py-2 fw-bold">
                        <i class="fas fa-comment-dots me-1"></i> Buka Forum
                    </a>
                </div>
            </div>

        </div>

        <!-- Recent Inquiries Table Preview -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
            <div class="card-header bg-light border-0 py-3 px-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0">
                    <i class="fas fa-clock text-primary me-2"></i> Permintaan Penawaran Terbaru
                </h5>
                <a href="?route=admin/inquiries" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                    Lihat Semua (<?= (int) ($inquiryStats['total'] ?? 0) ?>) <i class="fas fa-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 skm-table">
                    <thead>
                        <tr>
                            <th class="ps-4">No. Ref</th>
                            <th>Pemesan</th>
                            <th>Produk & Qty</th>
                            <th>Kontak</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recentInquiries)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    Belum ada permintaan penawaran yang masuk.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recentInquiries as $inq): ?>
                                <?php
                                $statusBadgeClass = match($inq['status']) {
                                    'new' => 'bg-primary',
                                    'contacted' => 'bg-info text-dark',
                                    'processing' => 'bg-warning text-dark',
                                    'quoted' => 'bg-success',
                                    'completed' => 'bg-secondary',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold font-monospace text-primary">
                                        <?= $escape($inq['reference_number']) ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= $escape($inq['name']) ?></div>
                                        <?php if (!empty($inq['company'])): ?>
                                            <small class="text-muted"><?= $escape($inq['company']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= $escape($inq['product_name'] ?: 'Seafood') ?>
                                        <small class="text-muted">(<?= $escape($inq['quantity'] ?: '-') ?>)</small>
                                    </td>
                                    <td class="font-monospace small">
                                        <?= $escape($inq['phone']) ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $statusBadgeClass ?> rounded-pill px-3 py-1">
                                            <?= strtoupper($escape($inq['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <?= date('d/m/Y H:i', strtotime($inq['created_at'])) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="?route=admin/inquiries/show&id=<?= (int) $inq['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Buka
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

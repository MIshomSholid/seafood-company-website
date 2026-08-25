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
    <title>Kelola Produk | Admin Samudra Kencana Mina</title>
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

                <a href="?route=admin/dashboard" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-th-large me-1"></i> Dashboard
                </a>

                <a href="?route=admin/logout" class="btn btn-danger btn-sm rounded-pill px-3">
                    <i class="fas fa-sign-out-alt me-1"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container py-5">

        <!-- Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="?route=admin/dashboard" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Kelola Produk</li>
                    </ol>
                </nav>
                <h1 class="h2 fw-bold text-dark mb-0">Daftar Produk Seafood</h1>
            </div>

            <a href="?route=admin/products/create" class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                <i class="fas fa-plus-circle me-1"></i> Tambah Produk Baru
            </a>
        </div>

        <!-- Alert Success -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fas fa-check-circle fs-5 flex-shrink-0"></i>
                <div><?= $escape($_SESSION['success']) ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- Alert Error -->
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                <i class="fas fa-exclamation-circle fs-5 flex-shrink-0"></i>
                <div><?= $escape($_SESSION['error']) ?></div>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <!-- Product Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 skm-table">
                        <thead>
                            <tr>
                                <th class="ps-4" style="width: 60px;">No</th>
                                <th style="width: 100px;">Gambar</th>
                                <th>Nama Produk</th>
                                <th>Deskripsi</th>
                                <th style="width: 130px;">Stok (kg)</th>
                                <th class="text-center pe-4" style="width: 180px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $index => $product): ?>
                                    <?php
                                    $productId = (int) $product['id'];
                                    $imageName = !empty($product['image']) ? basename($product['image']) : '';
                                    ?>
                                    <tr>
                                        <td class="ps-4 fw-bold text-muted"><?= $index + 1 ?></td>

                                        <td>
                                            <?php if (!empty($imageName)): ?>
                                                <img
                                                    src="public/assets/images/<?= $escape($imageName) ?>"
                                                    alt="<?= $escape($product['name']) ?>"
                                                    width="64"
                                                    height="64"
                                                    style="object-fit: cover; border-radius: 10px; border: 1px solid #e2e8f0;"
                                                    onerror="this.onerror=null; this.src='public/assets/images/logo.png';"
                                                >
                                            <?php else: ?>
                                                <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border" style="width: 64px; height: 64px;">
                                                    <i class="fas fa-fish text-muted fs-4"></i>
                                                </div>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <div class="fw-bold text-dark fs-6"><?= $escape($product['name']) ?></div>
                                            <small class="text-muted">ID: #<?= $productId ?></small>
                                        </td>

                                        <td>
                                            <div style="max-width: 320px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" class="text-secondary small">
                                                <?= $escape($product['description']) ?>
                                            </div>
                                        </td>

                                        <td>
                                            <?php if ((int) $product['stock'] > 0): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                                                    <?= (int) $product['stock'] ?> kg
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-pill fw-bold">
                                                    Habis (0 kg)
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center pe-4">
                                            <div class="btn-group shadow-xs">
                                                <a href="?route=admin/products/show&id=<?= $productId ?>" class="btn btn-sm btn-outline-info" title="Lihat Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="?route=admin/products/edit&id=<?= $productId ?>" class="btn btn-sm btn-outline-warning" title="Edit Data">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form method="POST" action="?route=admin/products/delete&id=<?= $productId ?>" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus produk <?= $escape($product['name']) ?>?')">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-end" title="Hapus Produk">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <i class="fas fa-box-open text-muted mb-3" style="font-size: 3rem;"></i>
                                        <h5 class="fw-bold">Belum Ada Data Produk</h5>
                                        <p class="text-muted small mb-3">Tambahkan produk seafood pertama ke dalam katalog sistem.</p>
                                        <a href="?route=admin/products/create" class="btn btn-primary rounded-pill px-4">
                                            <i class="fas fa-plus me-1"></i> Tambah Produk
                                        </a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
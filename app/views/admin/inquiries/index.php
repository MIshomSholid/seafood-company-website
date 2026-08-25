<?php
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
    <title>Manajemen Inquiry & Penawaran | PT Samudra Kencana Mina</title>
    <link rel="icon" type="image/png" href="public/assets/images/logo.png">

    <!-- Fonts & Bootstrap 5 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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

        <!-- Breadcrumb & Header -->
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="?route=admin/dashboard" class="text-decoration-none">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Inquiry & Penawaran</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">Daftar Permintaan Penawaran (Inquiries)</h1>
            </div>

            <div class="d-flex gap-2">
                <a href="?route=admin/dashboard" class="btn btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
                <a href="?route=admin/chat" class="btn btn-outline-primary rounded-pill px-3">
                    <i class="fas fa-comments me-1"></i> Log AI Chat
                </a>
            </div>
        </div>

        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-check-circle me-1"></i> <?= $escape($_SESSION['success']); unset($_SESSION['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-4" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i> <?= $escape($_SESSION['error']); unset($_SESSION['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                    <span class="text-muted small d-block">Total Permintaan</span>
                    <h3 class="fw-bold text-dark mb-0"><?= (int) ($stats['total'] ?? 0) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-primary border-4">
                    <span class="text-muted small d-block">Inquiry Baru</span>
                    <h3 class="fw-bold text-primary mb-0"><?= (int) ($stats['new'] ?? 0) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-warning border-4">
                    <span class="text-muted small d-block">Sedang Diproses</span>
                    <h3 class="fw-bold text-warning mb-0"><?= (int) ($stats['processing'] ?? 0) ?></h3>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-success border-4">
                    <span class="text-muted small d-block">Selesai / Quoted</span>
                    <h3 class="fw-bold text-success mb-0"><?= (int) ($stats['completed'] ?? 0) ?></h3>
                </div>
            </div>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
            <form method="GET" action="" class="row g-3 align-items-center">
                <input type="hidden" name="route" value="admin/inquiries">

                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input
                            type="text"
                            name="q"
                            class="form-control border-start-0"
                            placeholder="Cari nomor ref, nama, kontak, atau produk..."
                            value="<?= $escape($_GET['q'] ?? '') ?>"
                        >
                    </div>
                </div>

                <div class="col-md-3 col-6">
                    <select name="status" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?= (($_GET['status'] ?? '') === 'all') ? 'selected' : '' ?>>Semua Status</option>
                        <option value="new" <?= (($_GET['status'] ?? '') === 'new') ? 'selected' : '' ?>>Baru (New)</option>
                        <option value="contacted" <?= (($_GET['status'] ?? '') === 'contacted') ? 'selected' : '' ?>>Sudah Dihubungi</option>
                        <option value="processing" <?= (($_GET['status'] ?? '') === 'processing') ? 'selected' : '' ?>>Sedang Diproses</option>
                        <option value="quoted" <?= (($_GET['status'] ?? '') === 'quoted') ? 'selected' : '' ?>>Penawaran Diberikan</option>
                        <option value="completed" <?= (($_GET['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Selesai</option>
                        <option value="cancelled" <?= (($_GET['status'] ?? '') === 'cancelled') ? 'selected' : '' ?>>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-2 col-6">
                    <select name="priority" class="form-select" onchange="this.form.submit()">
                        <option value="all" <?= (($_GET['priority'] ?? '') === 'all') ? 'selected' : '' ?>>Semua Prioritas</option>
                        <option value="normal" <?= (($_GET['priority'] ?? '') === 'normal') ? 'selected' : '' ?>>Normal</option>
                        <option value="high" <?= (($_GET['priority'] ?? '') === 'high') ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= (($_GET['priority'] ?? '') === 'urgent') ? 'selected' : '' ?>>Urgent</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill">
                        Filter
                    </button>
                    <?php if (!empty($_GET['q']) || !empty($_GET['status']) || !empty($_GET['priority'])): ?>
                        <a href="?route=admin/inquiries" class="btn btn-light rounded-pill px-3" title="Reset Filter">
                            <i class="fas fa-undo"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </div>

        <!-- Inquiries Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 skm-table">
                    <thead>
                        <tr>
                            <th class="ps-4">No. Referensi</th>
                            <th>Pemesan / Perusahaan</th>
                            <th>Tipe Customer</th>
                            <th>Produk & Jumlah</th>
                            <th>Kontak WhatsApp</th>
                            <th>Status</th>
                            <th>Prioritas</th>
                            <th>Tanggal</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($inquiries)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fs-2 mb-2 d-block"></i>
                                    Tidak ada data permintaan penawaran yang sesuai.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($inquiries as $item): ?>
                                <?php
                                $statusBadgeClass = match($item['status']) {
                                    'new' => 'bg-primary',
                                    'contacted' => 'bg-info text-dark',
                                    'processing' => 'bg-warning text-dark',
                                    'quoted' => 'bg-success',
                                    'completed' => 'bg-secondary',
                                    'cancelled' => 'bg-danger',
                                    default => 'bg-secondary'
                                };

                                $priorityBadgeClass = match($item['priority']) {
                                    'urgent' => 'bg-danger',
                                    'high' => 'bg-warning text-dark',
                                    default => 'bg-light text-secondary border'
                                };

                                // Normalize Indonesian phone for WhatsApp direct link
                                $rawPhone = preg_replace('/[^0-9]/', '', $item['phone']);
                                if (str_starts_with($rawPhone, '0')) {
                                    $waCustomerPhone = '62' . substr($rawPhone, 1);
                                } elseif (str_starts_with($rawPhone, '62')) {
                                    $waCustomerPhone = $rawPhone;
                                } else {
                                    $waCustomerPhone = '62' . $rawPhone;
                                }

                                $waMessage = "Halo Bapak/Ibu {$item['name']},\nKami dari PT Samudra Kencana Mina menindaklanjuti permintaan penawaran Anda.\n\nNo. Inquiry: {$item['reference_number']}\nProduk: " . ($item['product_name'] ?: 'Seafood') . "\nJumlah: " . ($item['quantity'] ?: '-') . "\n\nApakah ada spesifikasi tambahan yang ingin didiskusikan? Terima kasih.";
                                $waUrl = "https://wa.me/{$waCustomerPhone}?text=" . rawurlencode($waMessage);
                                ?>
                                <tr>
                                    <td class="ps-4 fw-bold font-monospace text-primary">
                                        <a href="?route=admin/inquiries/show&id=<?= (int) $item['id'] ?>" class="text-decoration-none">
                                            <?= $escape($item['reference_number']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= $escape($item['name']) ?></div>
                                        <?php if (!empty($item['company'])): ?>
                                            <small class="text-muted d-block"><i class="fas fa-building me-1"></i><?= $escape($item['company']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($item['user_id'])): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1 small">
                                                <i class="fab fa-google me-1"></i> Customer Terdaftar
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">
                                                <i class="fas fa-user-secret me-1"></i> Guest
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="fw-semibold"><?= $escape($item['product_name'] ?: 'Kebutuhan Campuran') ?></div>
                                        <small class="text-muted"><i class="fas fa-weight-hanging me-1"></i><?= $escape($item['quantity'] ?: '-') ?></small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="font-monospace small"><?= $escape($item['phone']) ?></span>
                                            <a href="<?= $waUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-success px-2 py-0 rounded-pill" title="WhatsApp Customer">
                                                <i class="fab fa-whatsapp"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $statusBadgeClass ?> rounded-pill px-3 py-1">
                                            <?= strtoupper($escape($item['status'])) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $priorityBadgeClass ?> rounded-pill px-2 py-1">
                                            <?= strtoupper($escape($item['priority'])) ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <?= date('d/m/Y H:i', strtotime($item['created_at'])) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="?route=admin/inquiries/show&id=<?= (int) $item['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Detail
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
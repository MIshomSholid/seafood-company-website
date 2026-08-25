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
    <title>Log Percakapan AI Chat | PT Samudra Kencana Mina</title>
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
                <a href="?route=admin/dashboard" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-home me-1"></i> Dashboard
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
                        <li class="breadcrumb-item active" aria-current="page">Log AI Chat</li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">Log Percakapan Visitor & AI Assistant</h1>
            </div>

            <a href="?route=admin/inquiries" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-file-invoice me-1"></i> Lihat Data Inquiry
            </a>
        </div>

        <!-- Conversations Table Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 skm-table">
                    <thead>
                        <tr>
                            <th class="ps-4">ID / Sesi</th>
                            <th>Pengunjung / Akun</th>
                            <th>Tipe User</th>
                            <th>Judul Percakapan</th>
                            <th>Jumlah Pesan</th>
                            <th>Status</th>
                            <th>Waktu Terakhir</th>
                            <th class="text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($conversations)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-comments fs-2 mb-2 d-block"></i>
                                    Belum ada log percakapan AI.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($conversations as $c): ?>
                                <tr>
                                    <td class="ps-4 font-monospace small text-primary">
                                        <?= $escape(substr($c['session_id'], 0, 18)) ?>...
                                    </td>
                                    <td>
                                        <?php if (!empty($c['user_id'])): ?>
                                            <div class="d-flex align-items-center gap-2">
                                                <?php if (!empty($c['registered_avatar'])): ?>
                                                    <img src="<?= $escape($c['registered_avatar']) ?>" alt="Avatar" class="rounded-circle" width="24" height="24">
                                                <?php else: ?>
                                                    <i class="fas fa-user-circle fs-5 text-primary"></i>
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-semibold text-dark"><?= $escape($c['registered_name'] ?: $c['visitor_name']) ?></div>
                                                    <small class="text-muted"><?= $escape($c['registered_email'] ?: '-') ?></small>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="fw-semibold text-dark"><?= $escape($c['visitor_name'] ?: 'Visitor Publik') ?></div>
                                            <?php if (!empty($c['visitor_phone'])): ?>
                                                <small class="text-muted"><i class="fas fa-phone me-1"></i><?= $escape($c['visitor_phone']) ?></small>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($c['user_id'])): ?>
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-1 small">
                                                <i class="fab fa-google me-1"></i> Terdaftar
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-muted border rounded-pill px-2 py-1 small">
                                                <i class="fas fa-user-secret me-1"></i> Guest
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="text-secondary small"><?= $escape($c['title'] ?: 'Percakapan AI') ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1">
                                            <?= (int) ($c['message_count'] ?? 0) ?> pesan
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border rounded-pill px-3 py-1">
                                            <?= strtoupper($escape($c['status'])) ?>
                                        </span>
                                    </td>
                                    <td class="small text-muted">
                                        <?= date('d/m/Y H:i', strtotime($c['updated_at'])) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <a href="?route=admin/chat/show&id=<?= (int) $c['id'] ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> Buka Chat
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
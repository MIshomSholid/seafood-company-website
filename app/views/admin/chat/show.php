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
    <title>Log Percakapan #<?= (int) $conversation['id'] ?> | PT Samudra Kencana Mina</title>
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
                <a href="?route=admin/chat" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-list me-1"></i> Semua Log Chat
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
                        <li class="breadcrumb-item"><a href="?route=admin/chat" class="text-decoration-none">Log Chat</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Percakapan #<?= (int) $conversation['id'] ?></li>
                    </ol>
                </nav>
                <h1 class="h3 fw-bold text-dark mb-0">Rincian Percakapan Pengunjung & AI</h1>
            </div>

            <a href="?route=admin/chat" class="btn btn-outline-secondary rounded-pill px-4">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Log
            </a>
        </div>

        <div class="row g-4">

            <!-- Left: Visitor Info Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fas fa-id-card text-primary me-2"></i> Profil Percakapan
                    </h5>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Session ID</span>
                        <span class="font-monospace small fw-bold text-dark"><?= $escape($conversation['session_id']) ?></span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Nama Pengunjung</span>
                        <span class="fw-bold text-dark"><?= $escape($conversation['visitor_name'] ?: 'Pengunjung Publik') ?></span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Nomor Telepon</span>
                        <span class="fw-bold text-dark font-monospace"><?= $escape($conversation['visitor_phone'] ?: '-') ?></span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Email</span>
                        <span class="fw-bold text-dark"><?= $escape($conversation['visitor_email'] ?: '-') ?></span>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block">Waktu Mulai</span>
                        <span class="small text-muted"><?= date('d M Y H:i', strtotime($conversation['created_at'])) ?></span>
                    </div>
                </div>
            </div>

            <!-- Right: Chat Stream Bubble View -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white" style="min-height: 500px;">
                    <h5 class="fw-bold text-dark mb-4 border-bottom pb-2">
                        <i class="fas fa-comments text-primary me-2"></i> Transkrip Pesan (<?= count($messages) ?> Pesan)
                    </h5>

                    <div class="d-flex flex-column gap-3">
                        <?php if (empty($messages)): ?>
                            <p class="text-muted text-center py-5">Belum ada pesan dalam percakapan ini.</p>
                        <?php else: ?>
                            <?php foreach ($messages as $msg): ?>
                                <?php $isUser = ($msg['sender_type'] === 'user'); ?>
                                <div class="d-flex gap-3 <?= $isUser ? 'justify-content-end' : 'justify-content-start' ?>">
                                    <?php if (!$isUser): ?>
                                        <div class="skm-avatar-initial" style="width: 36px; height: 36px; background: linear-gradient(135deg, var(--skm-blue-600), var(--skm-teal-600));">
                                            <i class="fas fa-robot text-white small"></i>
                                        </div>
                                    <?php endif; ?>

                                    <div class="p-3 rounded-4 shadow-sm" style="max-width: 75%; background: <?= $isUser ? 'var(--skm-blue-600); color: #fff;' : 'var(--skm-gray-50); border: 1px solid var(--skm-gray-200); color: var(--skm-gray-800);' ?>">
                                        <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                                            <strong class="small"><?= $isUser ? 'Pengunjung' : 'SKM Assistant (AI)' ?></strong>
                                            <small class="<?= $isUser ? 'text-white-50' : 'text-muted' ?>" style="font-size: 0.7rem;">
                                                <?= date('H:i', strtotime($msg['created_at'])) ?>
                                            </small>
                                        </div>
                                        <div style="font-size: 0.9rem; line-height: 1.6; white-space: pre-line;">
                                            <?= $escape($msg['message']) ?>
                                        </div>
                                    </div>

                                    <?php if ($isUser): ?>
                                        <div class="skm-avatar-initial" style="width: 36px; height: 36px; background: var(--skm-navy-950);">
                                            <i class="fas fa-user text-white small"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
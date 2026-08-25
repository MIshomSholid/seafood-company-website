<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: ?route=admin/login');
    exit;
}
$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');

// Normalize customer phone for WhatsApp link
$rawPhone = preg_replace('/[^0-9]/', '', $inquiry['phone'] ?? '');
if (str_starts_with($rawPhone, '0')) {
    $waCustomerPhone = '62' . substr($rawPhone, 1);
} elseif (str_starts_with($rawPhone, '62')) {
    $waCustomerPhone = $rawPhone;
} else {
    $waCustomerPhone = '62' . $rawPhone;
}

$waMessage = "Halo Bapak/Ibu {$inquiry['name']},\n\nKami dari PT Samudra Kencana Mina menindaklanjuti permintaan penawaran Anda.\n\nNo. Inquiry: {$inquiry['reference_number']}\nProduk: " . ($inquiry['product_name'] ?: 'Seafood') . "\nJumlah: " . ($inquiry['quantity'] ?: '-') . "\n\nTerima kasih.";
$waCustomerUrl = "https://wa.me/{$waCustomerPhone}?text=" . rawurlencode($waMessage);
$waCompanyUrl = "https://wa.me/62318547202";
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Inquiry <?= $escape($inquiry['reference_number']) ?> | PT Samudra Kencana Mina</title>
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
                <a href="?route=admin/inquiries" class="btn btn-outline-light btn-sm rounded-pill px-3">
                    <i class="fas fa-list me-1"></i> Semua Inquiry
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
                        <li class="breadcrumb-item"><a href="?route=admin/inquiries" class="text-decoration-none">Inquiry</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= $escape($inquiry['reference_number']) ?></li>
                    </ol>
                </nav>
                <div class="d-flex align-items-center gap-3">
                    <h1 class="h3 fw-bold text-dark mb-0 font-monospace"><?= $escape($inquiry['reference_number']) ?></h1>
                    <span class="badge bg-primary fs-6 px-3 py-1 rounded-pill"><?= strtoupper($escape($inquiry['status'])) ?></span>
                </div>
            </div>

            <div class="d-flex gap-2">
                <a href="?route=admin/inquiries" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
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

        <div class="row g-4">

            <!-- Left Column: Customer & Product Information -->
            <div class="col-lg-7">

                <!-- Customer Details Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <h5 class="fw-bold text-dark mb-0">
                            <i class="fas fa-user-circle text-primary me-2"></i> Informasi Pemesan
                        </h5>
                        <?php if (!empty($inquiry['user_id'])): ?>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1">
                                <i class="fab fa-google me-1"></i> Customer Terdaftar (ID: <?= (int)$inquiry['user_id'] ?>)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1">
                                <i class="fas fa-user-secret me-1"></i> Guest Customer
                            </span>
                        <?php endif; ?>
                    </div>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Nama Lengkap</span>
                            <span class="fw-bold text-dark fs-6"><?= $escape($inquiry['name']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Perusahaan / Usaha</span>
                            <span class="fw-bold text-dark fs-6"><?= $escape($inquiry['company'] ?: '-') ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Nomor Telepon / WhatsApp</span>
                            <span class="fw-bold text-dark fs-6 font-monospace"><?= $escape($inquiry['phone']) ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Email</span>
                            <span class="fw-bold text-dark fs-6"><?= $escape($inquiry['email'] ?: '-') ?></span>
                        </div>
                    </div>

                    <!-- Direct Action Buttons for Customer -->
                    <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                        <a href="<?= $waCustomerUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success rounded-pill px-4 fw-semibold">
                            <i class="fab fa-whatsapp me-1"></i> Chat WhatsApp Customer
                        </a>
                        <a href="tel:<?= $escape($inquiry['phone']) ?>" class="btn btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-phone-alt me-1"></i> Telepon
                        </a>
                        <?php if (!empty($inquiry['email'])): ?>
                            <a href="mailto:<?= $escape($inquiry['email']) ?>" class="btn btn-outline-secondary rounded-pill px-3">
                                <i class="fas fa-envelope me-1"></i> Kirim Email
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Product Request Details Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fas fa-box-open text-primary me-2"></i> Rincian Kebutuhan Produk
                    </h5>

                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Produk Diminati</span>
                            <span class="fw-bold text-dark fs-5"><?= $escape($inquiry['product_name'] ?: 'Kebutuhan Campuran / Umum') ?></span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">Estimasi Volume / Jumlah</span>
                            <span class="badge bg-info text-dark fs-6 px-3 py-2 rounded-pill"><?= $escape($inquiry['quantity'] ?: '-') ?></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="text-muted small d-block mb-1">Catatan & Pesan Pemesan</span>
                        <div class="p-3 bg-light rounded-3 border text-secondary small" style="white-space: pre-line;">
                            <?= $escape($inquiry['message']) ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center small text-muted pt-2">
                        <span>Waktu Dibuat: <?= date('d M Y, H:i', strtotime($inquiry['created_at'])) ?> WIB</span>
                        <span>Terakhir Update: <?= date('d M Y, H:i', strtotime($inquiry['updated_at'])) ?> WIB</span>
                    </div>
                </div>

            </div>

            <!-- Right Column: Status Editor & Internal Notes -->
            <div class="col-lg-5">

                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-top" style="top: 80px;">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                        <i class="fas fa-tasks text-primary me-2"></i> Update Status & Catatan
                    </h5>

                    <form method="POST" action="?route=admin/inquiries/update&id=<?= (int) $inquiry['id'] ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="status" class="form-label small fw-semibold">Status Penanganan</label>
                            <select name="status" id="status" class="form-select">
                                <option value="new" <?= ($inquiry['status'] === 'new') ? 'selected' : '' ?>>New (Baru Masuk)</option>
                                <option value="contacted" <?= ($inquiry['status'] === 'contacted') ? 'selected' : '' ?>>Contacted (Customer Sudah Dihubungi)</option>
                                <option value="processing" <?= ($inquiry['status'] === 'processing') ? 'selected' : '' ?>>Processing (Sedang Dihitung / Disiapkan)</option>
                                <option value="quoted" <?= ($inquiry['status'] === 'quoted') ? 'selected' : '' ?>>Quoted (Penawaran Resmi Terkirim)</option>
                                <option value="completed" <?= ($inquiry['status'] === 'completed') ? 'selected' : '' ?>>Completed (Selesai Transaksi)</option>
                                <option value="cancelled" <?= ($inquiry['status'] === 'cancelled') ? 'selected' : '' ?>>Cancelled (Dibatalkan)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label small fw-semibold">Tingkat Prioritas</label>
                            <select name="priority" id="priority" class="form-select">
                                <option value="normal" <?= ($inquiry['priority'] === 'normal') ? 'selected' : '' ?>>Normal</option>
                                <option value="high" <?= ($inquiry['priority'] === 'high') ? 'selected' : '' ?>>High (Prioritas Tinggi)</option>
                                <option value="urgent" <?= ($inquiry['priority'] === 'urgent') ? 'selected' : '' ?>>Urgent (Mendesak / Volume Besar)</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="admin_note" class="form-label small fw-semibold">Catatan Internal Admin</label>
                            <textarea
                                name="admin_note"
                                id="admin_note"
                                class="form-control"
                                rows="5"
                                placeholder="Contoh: Sudah dikonfirmasi via WA, penawaran Rp... dikirim via email tanggal..."
                            ><?= $escape($inquiry['admin_note'] ?? '') ?></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold mb-2">
                            <i class="fas fa-save me-1"></i> Simpan Perubahan
                        </button>
                    </form>

                    <hr class="my-3">

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= $waCompanyUrl ?>" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                            <i class="fas fa-phone-alt me-1"></i> WhatsApp Kantor (+62 31 8547202)
                        </a>

                        <form method="POST" action="?route=admin/inquiries/delete&id=<?= (int) $inquiry['id'] ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data inquiry ini?');">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" title="Hapus Inquiry">
                                <i class="fas fa-trash-alt"></i> Hapus
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
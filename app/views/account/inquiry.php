<?php
require_once __DIR__ . '/../layouts/header.php';
$escape = static fn ($val): string => htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');

$statusOrder = ['new', 'contacted', 'processing', 'quoted', 'completed'];
$currentStatus = $inquiry['status'];
$currentIndex = array_search($currentStatus, $statusOrder);
if ($currentIndex === false) $currentIndex = 0;
?>

<main class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container py-3">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="?route=account" class="text-decoration-none text-muted small">
                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard Akun
                </a>
                <h3 class="fw-bold text-dark mt-1 mb-0">Detail Permintaan Penawaran</h3>
            </div>
            <div>
                <span class="badge bg-primary fs-6 px-3 py-2 rounded-pill font-monospace shadow-sm">
                    <?= $escape($inquiry['reference_number']) ?>
                </span>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left: Timeline Progress & Detail -->
            <div class="col-lg-8">
                <!-- Status Timeline Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-stream text-primary me-2"></i> Status Penanganan Penawaran</h5>

                    <?php if ($currentStatus === 'cancelled'): ?>
                        <div class="alert alert-secondary rounded-3 d-flex align-items-center gap-2 mb-0">
                            <i class="fas fa-ban fs-4"></i>
                            <div>Permintaan ini telah ditutup/dibatalkan. Silakan ajukan RFQ baru jika masih membutuhkan pasokan.</div>
                        </div>
                    <?php else: ?>
                        <div class="skm-timeline-wrapper py-2">
                            <div class="row text-center g-2 position-relative">
                                <?php
                                $steps = [
                                    ['code' => 'new', 'title' => 'Permintaan Diterima', 'icon' => 'fa-inbox'],
                                    ['code' => 'contacted', 'title' => 'Dihubungi Sales', 'icon' => 'fa-phone-alt'],
                                    ['code' => 'processing', 'title' => 'Sedang Diproses', 'icon' => 'fa-cogs'],
                                    ['code' => 'quoted', 'title' => 'Penawaran Dikirim', 'icon' => 'fa-file-invoice-dollar'],
                                    ['code' => 'completed', 'title' => 'Pesanan Selesai', 'icon' => 'fa-check-circle'],
                                ];
                                foreach ($steps as $idx => $step):
                                    $isPassed = ($idx <= $currentIndex);
                                    $isCurrent = ($step['code'] === $currentStatus);
                                    $stepClass = $isPassed ? 'text-success' : 'text-muted';
                                    $bgClass = $isCurrent ? 'bg-primary text-white shadow' : ($isPassed ? 'bg-success text-white' : 'bg-light text-muted border');
                                ?>
                                    <div class="col">
                                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2 <?= $bgClass ?>" style="width: 44px; height: 44px; font-size: 1.1rem;">
                                            <i class="fas <?= $step['icon'] ?>"></i>
                                        </div>
                                        <div class="small fw-bold <?= $stepClass ?>"><?= $step['title'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Inquiry Data Card -->
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Rincian Komoditas & Kebutuhan</h5>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-sm-6">
                            <div class="text-muted small">Produk yang Diminta:</div>
                            <div class="fw-bold fs-6 text-dark"><?= $escape($inquiry['product_name'] ?: 'Seafood Olahan Beku') ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Estimasi Volume:</div>
                            <div class="fw-bold fs-6 text-primary"><?= $escape($inquiry['quantity'] ?: '-') ?></div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Tanggal Pengajuan:</div>
                            <div class="text-dark"><?= date('d F Y, H:i', strtotime($inquiry['created_at'])) ?> WIB</div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted small">Tingkat Prioritas:</div>
                            <span class="badge bg-secondary-subtle text-dark border rounded-pill px-3 py-1"><?= ucfirst($inquiry['priority']) ?></span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="text-muted small mb-1">Catatan Kebutuhan / Spesifikasi:</div>
                        <div class="p-3 bg-light rounded-3 text-secondary small" style="white-space: pre-line;">
                            <?= $escape($inquiry['message']) ?>
                        </div>
                    </div>

                    <?php if (!empty($inquiry['product_description'])): ?>
                        <div class="p-3 bg-primary-subtle rounded-3 border border-primary-subtle">
                            <div class="fw-bold text-primary small mb-1"><i class="fas fa-info-circle me-1"></i> Informasi Standar Produk:</div>
                            <p class="small text-dark mb-0"><?= $escape($inquiry['product_description']) ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Customer Info & WhatsApp Action -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-lg-top" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">Kontak Penanggung Jawab</h5>
                    
                    <div class="mb-2">
                        <small class="text-muted">Nama Pemesan:</small>
                        <div class="fw-bold text-dark"><?= $escape($inquiry['name']) ?></div>
                    </div>
                    <?php if (!empty($inquiry['company'])): ?>
                        <div class="mb-2">
                            <small class="text-muted">Perusahaan / Usaha:</small>
                            <div class="text-dark"><?= $escape($inquiry['company']) ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="mb-2">
                        <small class="text-muted">WhatsApp / Telepon:</small>
                        <div class="text-dark"><?= $escape($inquiry['phone']) ?></div>
                    </div>
                    <?php if (!empty($inquiry['email'])): ?>
                        <div class="mb-4">
                            <small class="text-muted">Email:</small>
                            <div class="text-dark"><?= $escape($inquiry['email']) ?></div>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid gap-2 pt-3 border-top">
                        <?php
                        $waText = "Halo PT Samudra Kencana Mina, saya ingin menanyakan status Permintaan Penawaran No: " . $inquiry['reference_number'] . " (" . ($inquiry['product_name'] ?: 'Seafood') . "). Terima kasih.";
                        ?>
                        <a href="https://wa.me/62318547202?text=<?= urlencode($waText) ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success rounded-pill py-2 fw-semibold">
                            <i class="fab fa-whatsapp me-1"></i> Hubungi WhatsApp Kantor
                        </a>
                        <a href="tel:+62318547202" class="btn btn-outline-secondary rounded-pill py-2">
                            <i class="fas fa-phone-alt me-1"></i> Telepon Kantor SKM
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
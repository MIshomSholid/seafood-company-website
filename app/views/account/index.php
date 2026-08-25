<?php
require_once __DIR__ . '/../layouts/header.php';
$escape = static fn ($val): string => htmlspecialchars((string) $val, ENT_QUOTES, 'UTF-8');
?>

<main class="py-5 bg-light" style="min-height: 85vh;">
    <div class="container py-3">

        <!-- Top Profile Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
            <div class="card-body p-4 p-md-4 text-white" style="background: linear-gradient(135deg, #071326 0%, #0c2044 100%);">
                <div class="row align-items-center g-3">
                    <div class="col-auto">
                        <?php if (!empty($user['avatar'])): ?>
                            <img src="<?= $escape($user['avatar']) ?>" alt="<?= $escape($user['name']) ?>" class="rounded-circle border border-2 border-white shadow-sm" style="width: 72px; height: 72px; object-fit: cover;" onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($user['name']) ?>&background=0284c7&color=fff'">
                        <?php else: ?>
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fs-3 border border-2 border-white" style="width: 72px; height: 72px;">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col">
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                            <h4 class="fw-bold mb-0 text-white"><?= $escape($user['name']) ?></h4>
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 small">
                                <i class="fas fa-check-circle me-1"></i> Customer Terdaftar
                            </span>
                        </div>
                        <div class="small text-white-50 d-flex flex-wrap gap-3">
                            <span><i class="fas fa-envelope me-1 text-info"></i> <?= $escape($user['email']) ?></span>
                            <?php if (!empty($user['phone'])): ?>
                                <span><i class="fab fa-whatsapp me-1 text-success"></i> <?= $escape($user['phone']) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($user['company'])): ?>
                                <span><i class="fas fa-building me-1 text-warning"></i> <?= $escape($user['company']) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <a href="?route=auth/logout" class="btn btn-outline-light btn-sm rounded-pill px-3">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($flashSuccess)): ?>
            <div class="alert alert-success alert-dismissible fade show rounded-3 py-2 small d-flex align-items-center gap-2 mb-4 shadow-sm" role="alert">
                <i class="fas fa-check-circle fs-5 flex-shrink-0"></i>
                <div><?= $escape($flashSuccess) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (!empty($flashError)): ?>
            <div class="alert alert-danger alert-dismissible fade show rounded-3 py-2 small d-flex align-items-center gap-2 mb-4 shadow-sm" role="alert">
                <i class="fas fa-exclamation-circle fs-5 flex-shrink-0"></i>
                <div><?= $escape($flashError) ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Stat Cards -->
        <div class="row g-3 mb-4">
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 p-3 bg-primary-subtle text-primary fs-4">
                            <i class="fas fa-file-invoice"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Total Permintaan Penawaran</div>
                            <h3 class="fw-bold mb-0 text-dark"><?= (int) $stats['total_inquiries'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-6">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 p-3 bg-warning-subtle text-warning fs-4">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Inquiry Sedang Berjalan</div>
                            <h3 class="fw-bold mb-0 text-dark"><?= (int) $stats['active_inquiries'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="card border-0 shadow-sm rounded-4 p-3 bg-white h-100">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 p-3 bg-info-subtle text-info fs-4">
                            <i class="fas fa-comments"></i>
                        </div>
                        <div>
                            <div class="text-muted small">Sesi Chat AI Tersimpan</div>
                            <h3 class="fw-bold mb-0 text-dark"><?= (int) $stats['total_conversations'] ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="row g-4">
            <!-- Left: Inquiries & Chat history -->
            <div class="col-lg-8">
                <!-- Inquiries Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-file-invoice text-primary me-2"></i> Riwayat Permintaan Penawaran (RFQ)</h5>
                        <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#rfqModal">
                            <i class="fas fa-plus me-1"></i> Buat RFQ Baru
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($inquiries)): ?>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light small text-muted">
                                        <tr>
                                            <th class="ps-4">No. Referensi</th>
                                            <th>Produk & Qty</th>
                                            <th>Tanggal</th>
                                            <th>Status</th>
                                            <th class="text-end pe-4">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="small">
                                        <?php foreach ($inquiries as $inq): ?>
                                            <tr>
                                                <td class="ps-4 font-monospace fw-bold text-primary">
                                                    <?= $escape($inq['reference_number']) ?>
                                                </td>
                                                <td>
                                                    <div class="fw-bold text-dark"><?= $escape($inq['product_name'] ?: 'Seafood Pasokan') ?></div>
                                                    <small class="text-muted"><?= $escape($inq['quantity'] ?: '-') ?></small>
                                                </td>
                                                <td class="text-muted">
                                                    <?= date('d M Y', strtotime($inq['created_at'])) ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    $statusMap = [
                                                        'new' => ['label' => 'Diterima', 'class' => 'bg-info-subtle text-info border-info-subtle'],
                                                        'contacted' => ['label' => 'Dihubungi', 'class' => 'bg-primary-subtle text-primary border-primary-subtle'],
                                                        'processing' => ['label' => 'Diproses', 'class' => 'bg-warning-subtle text-warning border-warning-subtle'],
                                                        'quoted' => ['label' => 'Penawaran Dikirim', 'class' => 'bg-success-subtle text-success border-success-subtle'],
                                                        'completed' => ['label' => 'Selesai', 'class' => 'bg-success text-white border-success'],
                                                        'cancelled' => ['label' => 'Dibatalkan', 'class' => 'bg-secondary-subtle text-secondary border-secondary-subtle'],
                                                    ];
                                                    $st = $statusMap[$inq['status']] ?? ['label' => ucfirst($inq['status']), 'class' => 'bg-light text-dark'];
                                                    ?>
                                                    <span class="badge rounded-pill border px-2 py-1 <?= $st['class'] ?>">
                                                        <?= $st['label'] ?>
                                                    </span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <a href="?route=account/inquiry&id=<?= (int)$inq['id'] ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="text-center py-5">
                                <i class="fas fa-file-invoice text-muted fs-1 mb-2"></i>
                                <p class="text-muted mb-3">Belum ada riwayat permintaan penawaran harga.</p>
                                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#rfqModal">
                                    <i class="fas fa-paper-plane me-1"></i> Ajukan Penawaran Pertama
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Chat History Card -->
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 d-flex justify-content-between align-items-center border-bottom">
                        <h5 class="fw-bold text-dark mb-0"><i class="fas fa-robot text-info me-2"></i> Riwayat Percakapan SKM Assistant</h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" onclick="document.getElementById('skmAiChatTrigger').click();">
                            <i class="fas fa-comment-dots me-1"></i> Buka Chat
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <?php if (!empty($conversations)): ?>
                            <ul class="list-group list-group-flush small">
                                <?php foreach ($conversations as $c): ?>
                                    <li class="list-group-item p-3 d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark"><?= $escape($c['title'] ?: 'Percakapan AI') ?></div>
                                            <small class="text-muted">
                                                <i class="fas fa-clock me-1"></i> <?= date('d M Y H:i', strtotime($c['updated_at'])) ?> &bull; <?= (int)$c['message_count'] ?> pesan
                                            </small>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3" onclick="localStorage.setItem('skm_ai_session_id', '<?= $escape($c['session_id']) ?>'); document.getElementById('skmAiChatTrigger').click();">
                                            <i class="fas fa-comments me-1"></i> Lanjutkan
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <div class="text-center py-4 text-muted small">
                                Belum ada percakapan tersimpan. Buka SKM Assistant untuk mulai berdiskusi.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Right: Edit Profile Card -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-lg-top" style="top: 100px;">
                    <h5 class="fw-bold text-dark mb-3"><i class="fas fa-user-edit text-primary me-2"></i> Perbarui Profil</h5>
                    <form action="?route=account/update-profile" method="POST">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="profName" class="form-label small fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" id="profName" name="name" class="form-control" value="<?= $escape($user['name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="profEmail" class="form-label small fw-semibold">Email Google</label>
                            <input type="email" id="profEmail" class="form-control bg-light" value="<?= $escape($user['email']) ?>" readonly>
                            <small class="text-muted" style="font-size: 0.75rem;">Email terikat akun Google Anda.</small>
                        </div>
                        <div class="mb-3">
                            <label for="profPhone" class="form-label small fw-semibold">Nomor WhatsApp / HP</label>
                            <input type="tel" id="profPhone" name="phone" class="form-control" placeholder="Contoh: 08123456789" value="<?= $escape($user['phone'] ?? '') ?>">
                        </div>
                        <div class="mb-4">
                            <label for="profCompany" class="form-label small fw-semibold">Nama Usaha / Perusahaan</label>
                            <input type="text" id="profCompany" name="company" class="form-control" placeholder="Restoran, Katering, dll." value="<?= $escape($user['company'] ?? '') ?>">
                        </div>
                        <button type="submit" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold">
                            <i class="fas fa-save me-1"></i> Simpan Profil
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php
require_once __DIR__ . '/../../../config/security.php';

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="skm-section-padding bg-light" style="min-height: 80vh; padding-top: 130px;">
	<div class="container">

		<!-- Header & Breadcrumb -->
		<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
			<div>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="?route=home" class="text-decoration-none">Beranda</a></li>
						<li class="breadcrumb-item active" aria-current="page">Forum & Komentar</li>
					</ol>
				</nav>
				<h1 class="h2 fw-bold text-dark mb-0">Forum Diskusi & Ulasan Pengunjung</h1>
			</div>

			<div class="d-flex gap-2">
				<a href="?route=home#forum" class="btn btn-outline-secondary rounded-pill px-3">
					<i class="fas fa-home me-1"></i> Beranda
				</a>
				<?php if (isset($_SESSION['admin_id'])): ?>
					<a href="?route=admin/dashboard" class="btn btn-primary rounded-pill px-3">
						<i class="fas fa-user-shield me-1"></i> Dashboard Admin
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="row g-4">

			<!-- Left Column: Input Form -->
			<div class="col-lg-5">
				<div class="card border-0 shadow-sm rounded-4 p-4 sticky-top" style="top: 100px;">
					<div class="d-flex align-items-center gap-2 mb-3">
						<div class="skm-highlight-icon" style="width: 42px; height: 42px; font-size: 1.1rem;">
							<i class="fas fa-comment-medical"></i>
						</div>
						<h5 class="fw-bold mb-0 text-dark">Tulis Ulasan Baru</h5>
					</div>
					<p class="text-muted small mb-4">Sampaikan pendapat, ulasan mutu produk, atau masukan untuk PT Samudra Kencana Mina.</p>

					<form method="POST" action="?route=comment/store">
						<?= csrf_field() ?>
						<div class="mb-3">
							<label for="name" class="skm-form-label">Nama Lengkap</label>
							<div class="input-group">
								<span class="input-group-text bg-light"><i class="fas fa-user text-muted"></i></span>
								<input type="text" id="name" name="name" class="form-control skm-form-control" placeholder="Masukkan nama Anda" maxlength="255" required>
							</div>
						</div>
						<div class="mb-4">
							<label for="comment" class="skm-form-label">Komentar / Ulasan</label>
							<textarea id="comment" name="comment" class="form-control skm-form-control" rows="4" placeholder="Tuliskan pengalaman Anda..." maxlength="5000" required></textarea>
						</div>
						<button type="submit" class="skm-btn-primary w-100">
							<i class="fas fa-paper-plane me-1"></i> Kirim Ulasan
						</button>
					</form>
				</div>
			</div>

			<!-- Right Column: Comments List -->
			<div class="col-lg-7">
				<div class="d-flex justify-content-between align-items-center mb-3">
					<h5 class="fw-bold mb-0 text-dark">
						<i class="fas fa-comments text-primary me-2"></i>
						Daftar Komentar (<?= count($comments) ?>)
					</h5>
				</div>

				<?php if (empty($comments)): ?>
					<div class="card border-0 shadow-sm p-4 text-center">
						<i class="fas fa-comments text-muted mb-2" style="font-size: 2.5rem;"></i>
						<h6 class="fw-bold text-dark">Belum Ada Komentar</h6>
						<p class="text-muted small mb-0">Belum ada diskusi atau komentar dari pengunjung.</p>
					</div>
				<?php else: ?>
					<div class="d-flex flex-column gap-3">
						<?php foreach ($comments as $comment): ?>
							<?php
							$authorName = trim($comment['name'] ?? 'User');
							if ($authorName === '') $authorName = 'User';
							$initial = mb_substr($authorName, 0, 1, 'UTF-8');
							?>
							<div class="skm-comment-card">
								<div class="skm-comment-header">
									<div class="skm-avatar-initial">
										<?= $escape($initial) ?>
									</div>
									<div class="flex-grow-1">
										<div class="skm-comment-author"><?= $escape($authorName) ?></div>
										<?php if (!empty($comment['created_at'])): ?>
											<div class="skm-comment-meta">
												<i class="far fa-clock me-1"></i>
												<?= date('d M Y, H:i', strtotime($comment['created_at'])) ?>
											</div>
										<?php endif; ?>
									</div>
									<?php if (isset($_SESSION['admin_id'])): ?>
										<form method="POST" action="?route=comment/delete&id=<?= (int) $comment['id'] ?>" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');">
											<?= csrf_field() ?>
											<button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" title="Hapus Komentar">
												<i class="fas fa-trash-alt"></i>
											</button>
										</form>
									<?php endif; ?>
								</div>
								<p class="skm-comment-text">
									<?= nl2br($escape($comment['comment'] ?? '')) ?>
								</p>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

		</div>

	</div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>


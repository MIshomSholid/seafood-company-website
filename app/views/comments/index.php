<?php
require_once __DIR__ . '/../../../config/security.php';

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="section-padding">
	<div class="container">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h1 class="fw-bold mb-1">Komentar</h1>
				<p class="text-muted mb-0">Kelola diskusi pengunjung.</p>
			</div>
			<a href="?route=admin/dashboard" class="btn btn-primary"><i class="fas fa-arrow-left me-1"></i>Dashboard</a>
		</div>

		<div class="card mb-4">
			<div class="card-body">
				<form method="POST" action="?route=comment/store">
					<?= csrf_field() ?>
					<div class="mb-3">
						<label for="name" class="form-label">Nama</label>
						<input type="text" id="name" name="name" class="form-control" maxlength="255" required>
					</div>
					<div class="mb-3">
						<label for="comment" class="form-label">Komentar</label>
						<textarea id="comment" name="comment" class="form-control" maxlength="5000" required></textarea>
					</div>
					<button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i>Kirim</button>
				</form>
			</div>
		</div>

		<?php if (empty($comments)): ?>
			<div class="alert alert-info">Belum ada komentar.</div>
		<?php else: ?>
			<div class="list-group">
				<?php foreach ($comments as $comment): ?>
					<div class="list-group-item">
						<div class="d-flex justify-content-between">
							<strong><?= $escape($comment['name'] ?? 'User') ?></strong>
							<?php if (isset($comment['created_at'])): ?><small class="text-muted"><?= $escape($comment['created_at']) ?></small><?php endif; ?>
						</div>
						<p class="mb-3 mt-2"><?= nl2br($escape($comment['comment'] ?? '')) ?></p>
						<div class="d-flex gap-2">
							<form method="POST" action="?route=comment/delete&id=<?= (int) $comment['id'] ?>" onsubmit="return confirm('Hapus komentar ini?');">
								<?= csrf_field() ?>
								<button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i>Hapus</button>
							</form>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

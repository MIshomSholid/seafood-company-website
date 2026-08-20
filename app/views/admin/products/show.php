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
	<title>Detail Produk - Admin</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">
	<nav class="navbar navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand fw-bold" href="?route=admin/dashboard"><i class="fas fa-user-shield me-2"></i>Admin Panel</a>
			<div class="d-flex align-items-center">
				<span class="text-white me-3"><i class="fas fa-user me-1"></i><?= $escape($_SESSION['admin_name'] ?? 'Administrator') ?></span>
				<a href="?route=admin/logout" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
			</div>
		</div>
	</nav>

	<main class="container py-5">
		<div class="d-flex justify-content-between align-items-center mb-4">
			<div>
				<h1 class="fw-bold mb-1">Detail Produk</h1>
				<p class="text-muted mb-0">Informasi produk dalam katalog.</p>
			</div>
			<a href="?route=admin/products/edit&id=<?= (int) $product['id'] ?>" class="btn btn-warning"><i class="fas fa-edit me-1"></i>Edit Produk</a>
		</div>

		<div class="card border-0 shadow-sm">
			<div class="card-body p-4">
				<div class="row g-4">
					<div class="col-md-4 text-center">
							<?php if (!empty($product['image'])): ?>
							<img src="public/assets/images/<?= $escape(basename($product['image'])) ?>" alt="<?= $escape($product['name']) ?>" class="img-fluid rounded" style="max-height: 280px; object-fit: cover;">
						<?php else: ?>
							<div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 220px;"><i class="fas fa-image text-muted" style="font-size: 60px;"></i></div>
						<?php endif; ?>
					</div>
					<div class="col-md-8">
						<h2 class="h3 fw-bold"><?= $escape($product['name']) ?></h2>
						<p class="text-muted"><?= nl2br($escape($product['description'])) ?></p>
						<dl class="row">
							<dt class="col-sm-3">Stok</dt>
							<dd class="col-sm-9"><span class="badge <?= (int) $product['stock'] > 0 ? 'bg-success' : 'bg-secondary' ?>"><?= (int) $product['stock'] ?></span></dd>
							<?php if (!empty($product['image'])): ?>
								<dt class="col-sm-3">Gambar</dt>
								<dd class="col-sm-9"><?= $escape($product['image']) ?></dd>
							<?php endif; ?>
												<?php if (isset($product['created_at'])): ?>
													<dt class="col-sm-3">Dibuat</dt>
													<dd class="col-sm-9"><?= $escape($product['created_at']) ?></dd>
												<?php endif; ?>
												<?php if (isset($product['updated_at'])): ?>
													<dt class="col-sm-3">Diperbarui</dt>
													<dd class="col-sm-9"><?= $escape($product['updated_at']) ?></dd>
												<?php endif; ?>
						</dl>
					</div>
				</div>
				<a href="?route=admin/products" class="btn btn-secondary mt-4"><i class="fas fa-arrow-left me-1"></i>Kembali ke Kelola Produk</a>
			</div>
		</div>
	</main>
</body>
</html>

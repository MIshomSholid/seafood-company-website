<?php
if (!isset($_SESSION['admin_id'])) {
	header('Location: ?route=admin/login');
	exit;
}

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
$productId = (int) ($product['id'] ?? 0);
$imageName = !empty($product['image']) ? basename($product['image']) : '';
?>

<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Detail Produk | Admin Samudra Kencana Mina</title>
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

				<a href="?route=admin/products" class="btn btn-outline-light btn-sm rounded-pill px-3">
					<i class="fas fa-boxes me-1"></i> Data Produk
				</a>

				<a href="?route=admin/logout" class="btn btn-danger btn-sm rounded-pill px-3">
					<i class="fas fa-sign-out-alt me-1"></i> Logout
				</a>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<main class="container py-5">

		<!-- Breadcrumb & Header -->
		<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
			<div>
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-1">
						<li class="breadcrumb-item"><a href="?route=admin/dashboard" class="text-decoration-none">Dashboard</a></li>
						<li class="breadcrumb-item"><a href="?route=admin/products" class="text-decoration-none">Produk</a></li>
						<li class="breadcrumb-item active" aria-current="page">Detail: <?= $escape($product['name'] ?? '') ?></li>
					</ol>
				</nav>
				<h1 class="h2 fw-bold text-dark mb-0">Detail Data Produk</h1>
			</div>

			<div class="d-flex gap-2">
				<a href="?route=admin/products/edit&id=<?= $productId ?>" class="btn btn-warning rounded-pill px-4">
					<i class="fas fa-edit me-1"></i> Edit Data
				</a>
				<a href="?route=admin/products" class="btn btn-outline-secondary rounded-pill px-3">
					<i class="fas fa-arrow-left me-1"></i> Kembali
				</a>
			</div>
		</div>

		<!-- Detail Card -->
		<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
			<div class="card-body p-4 p-sm-5">
				<div class="row g-5">

					<!-- Visual Column -->
					<div class="col-lg-4 text-center">
						<div class="rounded-4 overflow-hidden border shadow-sm bg-light mb-3" style="aspect-ratio: 4/3;">
							<?php if (!empty($imageName)): ?>
								<img
									src="public/assets/images/<?= $escape($imageName) ?>"
									alt="<?= $escape($product['name'] ?? '') ?>"
									class="img-fluid w-100 h-100"
									style="object-fit: cover;"
									onerror="this.onerror=null; this.src='public/assets/images/logo.png';"
								>
							<?php else: ?>
								<div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted">
									<i class="fas fa-fish" style="font-size: 4rem;"></i>
								</div>
							<?php endif; ?>
						</div>

						<span class="badge bg-primary px-3 py-2 rounded-pill">
							ID Produk: #<?= $productId ?>
						</span>
					</div>

					<!-- Data Column -->
					<div class="col-lg-8">
						<span class="skm-eyebrow mb-2">Informasi Produk Seafood</span>
						<h2 class="h3 fw-bold text-dark mb-3"><?= $escape($product['name'] ?? '') ?></h2>

						<div class="mb-4">
							<h6 class="fw-bold text-dark mb-2">Deskripsi Produk:</h6>
							<p class="text-secondary" style="line-height: 1.7; white-space: pre-line;"><?= $escape($product['description'] ?? '') ?></p>
						</div>

						<div class="card bg-light border-0 rounded-3 p-4 mb-4">
							<div class="row g-3">
								<div class="col-sm-6">
									<span class="small text-muted d-block">Status Stok:</span>
									<span class="badge <?= (int) ($product['stock'] ?? 0) > 0 ? 'bg-success' : 'bg-danger' ?> fs-6 px-3 py-2 rounded-pill mt-1">
										<?= (int) ($product['stock'] ?? 0) ?> kg
									</span>
								</div>
								<div class="col-sm-6">
									<span class="small text-muted d-block">Nama File Foto:</span>
									<strong class="text-dark d-block mt-1 small"><?= $escape($imageName ?: 'Tidak ada gambar') ?></strong>
								</div>
								<?php if (isset($product['created_at'])): ?>
									<div class="col-sm-6">
										<span class="small text-muted d-block">Waktu Dibuat:</span>
										<span class="text-secondary small"><?= $escape($product['created_at']) ?></span>
									</div>
								<?php endif; ?>
								<?php if (isset($product['updated_at'])): ?>
									<div class="col-sm-6">
										<span class="small text-muted d-block">Terakhir Diperbarui:</span>
										<span class="text-secondary small"><?= $escape($product['updated_at']) ?></span>
									</div>
								<?php endif; ?>
							</div>
						</div>

					</div>

				</div>
			</div>
		</div>

	</main>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>


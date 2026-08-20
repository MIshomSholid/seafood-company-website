<?php
require_once __DIR__ . '/../../../../config/security.php';

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
	<title>Edit Produk - Admin</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link rel="stylesheet" href="public/css/style.css">
</head>
<body class="bg-light">
	<nav class="navbar navbar-dark bg-primary">
		<div class="container">
			<a class="navbar-brand fw-bold" href="?route=admin/dashboard">
				<i class="fas fa-user-shield me-2"></i>Admin Panel
			</a>
			<div class="d-flex align-items-center">
				<span class="text-white me-3"><i class="fas fa-user me-1"></i><?= $escape($_SESSION['admin_name'] ?? 'Administrator') ?></span>
				<a href="?route=admin/logout" class="btn btn-outline-light btn-sm"><i class="fas fa-sign-out-alt me-1"></i>Logout</a>
			</div>
		</div>
	</nav>

	<main class="container py-5">
		<div class="row justify-content-center">
			<div class="col-lg-8">
				<h1 class="fw-bold mb-1">Edit Produk</h1>
				<p class="text-muted mb-4">Perbarui informasi produk.</p>

				<?php if (!empty($_SESSION['error'])): ?>
					<div class="alert alert-danger"><?= $escape($_SESSION['error']) ?></div>
					<?php unset($_SESSION['error']); ?>
				<?php endif; ?>

				<div class="card border-0 shadow-sm">
					<div class="card-body p-4">
						<form method="POST" action="?route=admin/products/update&id=<?= (int) $product['id'] ?>" enctype="multipart/form-data">
							<?= csrf_field() ?>
							<div class="mb-4">
								<label for="name" class="form-label fw-semibold">Nama Produk</label>
								<input type="text" id="name" name="name" class="form-control" value="<?= $escape($product['name'] ?? '') ?>" maxlength="255" required>
							</div>
							<div class="mb-4">
								<label for="description" class="form-label fw-semibold">Deskripsi</label>
								<textarea id="description" name="description" class="form-control" rows="5" required><?= $escape($product['description'] ?? '') ?></textarea>
							</div>
							<div class="mb-4">
								<label for="stock" class="form-label fw-semibold">Stok</label>
								<input type="number" id="stock" name="stock" class="form-control" value="<?= (int) ($product['stock'] ?? 0) ?>" min="0" required>
							</div>
							<div class="mb-4">
								<label for="image" class="form-label fw-semibold">Gambar Produk</label>
								<?php if (!empty($product['image'])): ?>
									<img src="public/assets/images/<?= $escape(basename($product['image'])) ?>" class="img-thumbnail d-block mb-2" style="max-height: 160px;" alt="Gambar lama produk">
								<?php endif; ?>
								<input type="file" id="image" name="image" class="form-control" accept="image/jpeg,image/png,image/webp">
								<div class="form-text">Kosongkan jika tidak ingin mengganti gambar. Maksimal 2 MB.</div>
								<img id="image-preview" class="img-fluid rounded mt-3 d-none" style="max-height: 220px;" alt="Preview gambar baru">
							</div>
							<div class="d-flex justify-content-between">
								<a href="?route=admin/products" class="btn btn-secondary"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
								<button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</main>
</body>
<script>
	document.getElementById('image').addEventListener('change', function (event) {
		const preview = document.getElementById('image-preview');
		const file = event.target.files[0];
		if (!file) {
			preview.classList.add('d-none');
			preview.removeAttribute('src');
			return;
		}
		preview.src = URL.createObjectURL(file);
		preview.classList.remove('d-none');
	});
</script>
</html>

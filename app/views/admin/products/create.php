<?php
require_once __DIR__ . '/../../../../config/security.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: ?route=admin/login');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Produk - Admin</title>

    <!-- Bootstrap 5 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    >

    <!-- Custom CSS -->
    <link
        rel="stylesheet"
        href="public/css/style.css"
    >
</head>

<body class="bg-light">

    <!-- Navbar Admin -->
    <nav class="navbar navbar-dark bg-primary">

        <div class="container">

            <a
                class="navbar-brand fw-bold"
                href="?route=admin/dashboard"
            >
                <i class="fas fa-user-shield me-2"></i>
                Admin Panel
            </a>

            <div class="d-flex align-items-center">

                <span class="text-white me-3">
                    <i class="fas fa-user me-1"></i>
                    <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Administrator') ?>
                </span>

                <a
                    href="?route=admin/logout"
                    class="btn btn-outline-light btn-sm"
                >
                    <i class="fas fa-sign-out-alt me-1"></i>
                    Logout
                </a>

            </div>

        </div>

    </nav>


    <!-- Content -->
    <main class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <!-- Header -->
                <div class="mb-4">

                    <h1 class="fw-bold">
                        Tambah Produk
                    </h1>

                    <p class="text-muted mb-0">
                        Tambahkan produk baru ke katalog PT Samudra Kencana Mina.
                    </p>

                </div>

                <?php if (!empty($_SESSION['error'])): ?>
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= htmlspecialchars($_SESSION['error'], ENT_QUOTES, 'UTF-8') ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>


                <!-- Form Card -->
                <div class="card border-0 shadow-sm">

                    <div class="card-body p-4">

                        <form
                            method="POST"
                            action="?route=admin/products/store"
                            enctype="multipart/form-data"
                        >

                            <?= csrf_field() ?>

                            <!-- Nama Produk -->
                            <div class="mb-4">

                                <label
                                    for="name"
                                    class="form-label fw-semibold"
                                >
                                    Nama Produk
                                </label>

                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    class="form-control"
                                    placeholder="Masukkan nama produk"
                                    required
                                    maxlength="255"
                                >

                            </div>


                            <!-- Deskripsi -->
                            <div class="mb-4">

                                <label
                                    for="description"
                                    class="form-label fw-semibold"
                                >
                                    Deskripsi
                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    class="form-control"
                                    rows="5"
                                    placeholder="Masukkan deskripsi produk"
                                    required
                                ></textarea>

                            </div>


                            <!-- Stok -->
                            <div class="mb-4">

                                <label
                                    for="stock"
                                    class="form-label fw-semibold"
                                >
                                    Stok
                                </label>

                                <input
                                    type="number"
                                    id="stock"
                                    name="stock"
                                    class="form-control"
                                    placeholder="Masukkan jumlah stok"
                                    min="0"
                                    value="0"
                                    required
                                >

                            </div>


                            <!-- Gambar -->
                            <div class="mb-4">

                                <label
                                    for="image"
                                    class="form-label fw-semibold"
                                >
                                    Gambar Produk
                                </label>

                                <input
                                    type="file"
                                    id="image"
                                    name="image"
                                    class="form-control"
                                    accept="image/jpeg,image/png,image/webp"
                                >

                                <div class="form-text">
                                    Pilih gambar JPEG, PNG, atau WebP maksimal 2 MB.
                                </div>

                                <img id="image-preview" class="img-fluid rounded mt-3 d-none" style="max-height: 220px;" alt="Preview gambar produk">

                            </div>


                            <!-- Buttons -->
                            <div
                                class="d-flex justify-content-between align-items-center mt-4"
                            >

                                <a
                                    href="?route=admin/products"
                                    class="btn btn-secondary"
                                >
                                    <i class="fas fa-arrow-left me-1"></i>
                                    Kembali
                                </a>

                                <button
                                    type="submit"
                                    class="btn btn-primary"
                                >
                                    <i class="fas fa-save me-1"></i>
                                    Simpan Produk
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </main>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
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

</body>

</html>
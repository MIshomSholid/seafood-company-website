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

    <title>Kelola Produk - Samudra Kencana Mina</title>

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


    <!-- Main Content -->
    <main class="container py-5">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h1 class="fw-bold mb-1">
                    Kelola Produk
                </h1>

                <p class="text-muted mb-0">
                    Kelola data produk dan stok PT Samudra Kencana Mina.
                </p>

            </div>

            <a
                href="?route=admin/products/create"
                class="btn btn-primary"
            >
                <i class="fas fa-plus me-1"></i>
                Tambah Produk
            </a>

        </div>


        <!-- Alert Success -->
        <?php if (!empty($_SESSION['success'])): ?>

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-check-circle me-2"></i>

                <?= htmlspecialchars($_SESSION['success']) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

            <?php unset($_SESSION['success']); ?>

        <?php endif; ?>


        <!-- Alert Error -->
        <?php if (!empty($_SESSION['error'])): ?>

            <div
                class="alert alert-danger alert-dismissible fade show"
                role="alert"
            >
                <i class="fas fa-exclamation-circle me-2"></i>

                <?= htmlspecialchars($_SESSION['error']) ?>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

            <?php unset($_SESSION['error']); ?>

        <?php endif; ?>


        <!-- Product Table -->
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-primary">

                            <tr>

                                <th class="px-4">
                                    No
                                </th>

                                <th>
                                    Gambar
                                </th>

                                <th>
                                    Nama Produk
                                </th>

                                <th>
                                    Deskripsi
                                </th>

                                <th>
                                    Stok
                                </th>

                                <th class="text-center">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($products)): ?>

                                <?php foreach ($products as $index => $product): ?>

                                    <tr>

                                        <!-- Number -->
                                        <td class="px-4">
                                            <?= $index + 1 ?>
                                        </td>


                                        <!-- Image -->
                                        <td>

                                            <?php if (!empty($product['image'])): ?>

                                                <img
                                                    src="public/assets/images/<?= htmlspecialchars(basename($product['image']), ENT_QUOTES, 'UTF-8') ?>"
                                                    alt="<?= htmlspecialchars($product['name']) ?>"
                                                    width="70"
                                                    height="70"
                                                    style="
                                                        object-fit: cover;
                                                        border-radius: 8px;
                                                    "
                                                >

                                            <?php else: ?>

                                                <div
                                                    class="bg-light d-flex align-items-center justify-content-center"
                                                    style="
                                                        width: 70px;
                                                        height: 70px;
                                                        border-radius: 8px;
                                                    "
                                                >

                                                    <i
                                                        class="fas fa-image text-muted"
                                                        style="font-size: 25px;"
                                                    ></i>

                                                </div>

                                            <?php endif; ?>

                                        </td>


                                        <!-- Name -->
                                        <td>

                                            <strong>
                                                <?= htmlspecialchars($product['name']) ?>
                                            </strong>

                                        </td>


                                        <!-- Description -->
                                        <td>

                                            <div
                                                style="
                                                    max-width: 300px;
                                                    overflow: hidden;
                                                    text-overflow: ellipsis;
                                                    white-space: nowrap;
                                                "
                                            >
                                                <?= htmlspecialchars($product['description']) ?>
                                            </div>

                                        </td>


                                        <!-- Stock -->
                                        <td>

                                            <?php if ((int) $product['stock'] > 0): ?>

                                                <span class="badge bg-success">
                                                    <?= (int) $product['stock'] ?>
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-secondary">
                                                    0
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- Actions -->
                                        <td class="text-center">

                                            <div class="btn-group">

                                                <a
                                                    href="?route=admin/products/show&id=<?= (int) $product['id'] ?>"
                                                    class="btn btn-sm btn-info text-white"
                                                    title="Detail"
                                                >
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a
                                                    href="?route=admin/products/edit&id=<?= (int) $product['id'] ?>"
                                                    class="btn btn-sm btn-warning"
                                                    title="Edit"
                                                >
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form
                                                    method="POST"
                                                    action="?route=admin/products/delete&id=<?= (int) $product['id'] ?>"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')"
                                                >
                                                    <?= csrf_field() ?>
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Hapus"
                                                    >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="6"
                                        class="text-center py-5"
                                    >

                                        <div class="text-muted">

                                            <i
                                                class="fas fa-box-open mb-3"
                                                style="font-size: 50px;"
                                            ></i>

                                            <h5>
                                                Belum Ada Produk
                                            </h5>

                                            <p class="mb-3">
                                                Belum ada data produk yang tersedia.
                                            </p>

                                            <a
                                                href="?route=admin/products/create"
                                                class="btn btn-primary"
                                            >
                                                <i class="fas fa-plus me-1"></i>
                                                Tambah Produk
                                            </a>

                                        </div>

                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


        <!-- Back -->
        <div class="mt-4">

            <a
                href="?route=admin/dashboard"
                class="text-decoration-none"
            >
                <i class="fas fa-arrow-left me-1"></i>
                Kembali ke Dashboard
            </a>

        </div>

    </main>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>
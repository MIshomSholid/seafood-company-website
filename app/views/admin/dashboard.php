<?php
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

    <title>Dashboard Admin - Samudra Kencana Mina</title>

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

        <!-- Welcome -->
        <div class="mb-4">

            <h1 class="fw-bold">
                Dashboard Admin
            </h1>

            <p class="text-muted">
                Selamat datang di panel administrasi
                PT Samudra Kencana Mina.
            </p>

        </div>


        <!-- Dashboard Cards -->
        <div class="row g-4">


            <!-- Products -->
            <div class="col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="card-title fw-bold">
                                    Produk
                                </h5>

                                <p class="text-muted">
                                    Kelola data produk,
                                    stok, deskripsi,
                                    dan gambar.
                                </p>

                            </div>

                            <div class="text-primary">

                                <i
                                    class="fas fa-box-open"
                                    style="font-size: 40px;"
                                ></i>

                            </div>

                        </div>

                        <a
                            href="?route=admin/products"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-cog me-1"></i>
                            Kelola Produk
                        </a>

                    </div>

                </div>

            </div>


            <!-- Comments -->
            <div class="col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="card-title fw-bold">
                                    Forum
                                </h5>

                                <p class="text-muted">
                                    Kelola komentar dan
                                    diskusi pengguna.
                                </p>

                            </div>

                            <div class="text-success">

                                <i
                                    class="fas fa-comments"
                                    style="font-size: 40px;"
                                ></i>

                            </div>

                        </div>

                        <a
                            href="?route=comments"
                            class="btn btn-success"
                        >
                            <i class="fas fa-comments me-1"></i>
                            Kelola Forum
                        </a>

                    </div>

                </div>

            </div>


            <!-- Website -->
            <div class="col-md-6 col-lg-4">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>

                                <h5 class="card-title fw-bold">
                                    Website
                                </h5>

                                <p class="text-muted">
                                    Kembali melihat
                                    halaman utama website.
                                </p>

                            </div>

                            <div class="text-info">

                                <i
                                    class="fas fa-globe"
                                    style="font-size: 40px;"
                                ></i>

                            </div>

                        </div>

                        <a
                            href="?route=home"
                            class="btn btn-info text-white"
                        >
                            <i class="fas fa-external-link-alt me-1"></i>
                            Lihat Website
                        </a>

                    </div>

                </div>

            </div>

        </div>


        <!-- Information -->
        <div class="card border-0 shadow-sm mt-5">

            <div class="card-body p-4">

                <h5 class="fw-bold mb-3">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi
                </h5>

                <p class="mb-0 text-muted">
                    Gunakan menu di atas untuk mengelola
                    data website PT Samudra Kencana Mina.
                </p>

            </div>

        </div>

    </main>


    <!-- Bootstrap JS -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>

</body>

</html>
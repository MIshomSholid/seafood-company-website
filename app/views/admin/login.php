<?php
require_once __DIR__ . '/../../../config/security.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login Admin - Samudra Kencana Mina</title>

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

    <div class="container">

        <div
            class="row justify-content-center align-items-center"
            style="min-height: 100vh;"
        >

            <div class="col-md-5 col-lg-4">

                <div class="card shadow border-0">

                    <div class="card-body p-4">

                        <!-- Header -->
                        <div class="text-center mb-4">

                            <div class="mb-3">

                                <i
                                    class="fas fa-user-shield"
                                    style="font-size: 50px; color: #1a237e;"
                                ></i>

                            </div>

                            <h3 class="fw-bold">
                                Admin Login
                            </h3>

                            <p class="text-muted mb-0">
                                PT Samudra Kencana Mina
                            </p>

                        </div>


                        <!-- Error Message -->
                        <?php if (!empty($_SESSION['error'])): ?>

                            <div
                                class="alert alert-danger"
                                role="alert"
                            >
                                <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>

                            <?php unset($_SESSION['error']); ?>

                        <?php endif; ?>


                        <!-- Login Form -->
                        <form
                            method="POST"
                            action="?route=admin/authenticate"
                        >

                            <?= csrf_field() ?>

                            <!-- Username -->
                            <div class="mb-3">

                                <label
                                    for="username"
                                    class="form-label"
                                >
                                    Username
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>

                                    <input
                                        type="text"
                                        id="username"
                                        name="username"
                                        class="form-control"
                                        placeholder="Masukkan username"
                                        required
                                        autocomplete="username"
                                    >

                                </div>

                            </div>


                            <!-- Password -->
                            <div class="mb-4">

                                <label
                                    for="password"
                                    class="form-label"
                                >
                                    Password
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>

                                    <input
                                        type="password"
                                        id="password"
                                        name="password"
                                        class="form-control"
                                        placeholder="Masukkan password"
                                        required
                                        autocomplete="current-password"
                                    >

                                </div>

                            </div>


                            <!-- Submit -->
                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Login
                            </button>

                        </form>


                        <!-- Back to Website -->
                        <div class="text-center mt-4">

                            <a
                                href="?route=home"
                                class="text-decoration-none"
                            >
                                <i class="fas fa-arrow-left me-1"></i>
                                Kembali ke Website
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
<?php
require_once __DIR__ . '/../../../config/security.php';
require_once __DIR__ . '/../layouts/header.php';
?>

<main>

    <!-- ============================================
         HERO SECTION
         ============================================ -->

    <section id="beranda" class="hero-section">
        <div class="container text-center">

            <h1 class="display-4 mb-4">
                Selamat Datang di Fresh Frozen Food
            </h1>

            <p class="lead mb-4">
                Kualitas Terbaik untuk Hidangan Anda
            </p>

            <a href="#produk" class="btn btn-primary btn-lg">
                Lihat Produk Kami
            </a>

        </div>
    </section>


    <!-- ============================================
         TENTANG KAMI
         ============================================ -->

    <section id="tentang" class="section-padding section-animation">
        <div class="container">

            <h2 class="text-center mb-5">
                Tentang Kami
            </h2>

            <div class="row align-items-center">

                <div class="col-lg-6 mb-4">

                    <img
                        src="public/assets/images/logo.png"
                        alt="PT Samudra Kencana Mina"
                        class="img-fluid about-img"
                    >

                </div>

                <div class="col-lg-6">

                    <h3 class="mb-4">
                        Fresh Frozen Food - Keunggulan dalam Setiap Produk
                    </h3>

                    <p>
                        PT Samudra Kencana Mina adalah perusahaan makanan beku
                        terkemuka yang berkomitmen untuk menyediakan produk
                        berkualitas tinggi dengan standar keamanan pangan yang ketat.
                    </p>

                    <p>
                        Dengan pengalaman lebih dari 10 tahun dalam industri
                        makanan beku, kami terus berinovasi untuk menghadirkan
                        produk-produk terbaik bagi konsumen kami.
                    </p>

                    <p>
                        Visi kami adalah menjadi pemimpin dalam industri makanan
                        beku dengan mengutamakan kualitas, inovasi, dan kepuasan pelanggan.
                    </p>

                </div>

            </div>

        </div>
    </section>


    <!-- ============================================
         PRODUK
         ============================================ -->

    <section id="produk" class="section-padding section-animation bg-light">

        <div class="container">

            <h2 class="text-center mb-5">
                Produk Kami
            </h2>

            <div class="row">

                <?php if (empty($products)): ?>

                    <div class="col-12">

                        <div class="alert alert-info text-center">
                            Produk belum tersedia.
                        </div>

                    </div>

                <?php else: ?>

                    <?php foreach ($products as $product): ?>

                        <?php
                        $productId = (int) $product['id'];

                        $productRating = $ratings[$productId] ?? [
                            'average' => 0,
                            'count' => 0,
                        ];
                        ?>

                        <div class="col-md-6 mb-4">

                            <div class="card product-card h-100">

                                <?php if (!empty($product['image'])): ?>

                                    <img
                                        src="public/assets/images/<?= htmlspecialchars($product['image']) ?>"
                                        class="card-img-top"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                    >

                                <?php endif; ?>


                                <div class="card-body">

                                    <h5 class="card-title">
                                        <?= htmlspecialchars($product['name']) ?>
                                    </h5>

                                    <p class="card-text">
                                        <?= htmlspecialchars($product['description']) ?>
                                    </p>

                                    <p>
                                        <strong>
                                            Stok tersisa:
                                            <?= (int) $product['stock'] ?>
                                        </strong>
                                    </p>


                                    <!-- Rating -->
                                    <div class="mb-3">

                                        <p class="mb-2">
                                            <strong>
                                                Rating:
                                            </strong>

                                            <?php if ($productRating['count'] > 0): ?>

                                                <?= number_format(
                                                    $productRating['average'],
                                                    2
                                                ) ?>

                                                / 5

                                                <small class="text-muted">
                                                    (
                                                    <?= (int) $productRating['count'] ?>
                                                    rating
                                                    )
                                                </small>

                                            <?php else: ?>

                                                <span class="text-muted">
                                                    Belum ada rating
                                                </span>

                                            <?php endif; ?>

                                        </p>

                                    </div>


                                    <!-- Beri Rating -->
                                    <form
                                        method="POST"
                                        action="?route=rating/store"
                                    >

                                        <?= csrf_field() ?>

                                        <input
                                            type="hidden"
                                            name="product_id"
                                            value="<?= $productId ?>"
                                        >

                                        <label
                                            for="rating-<?= $productId ?>"
                                            class="form-label"
                                        >
                                            Beri Rating:
                                        </label>

                                        <select
                                            id="rating-<?= $productId ?>"
                                            name="rating"
                                            class="form-select"
                                            required
                                        >

                                            <option value="">
                                                Pilih Rating
                                            </option>

                                            <option value="1">
                                                1 - Sangat Buruk
                                            </option>

                                            <option value="2">
                                                2 - Buruk
                                            </option>

                                            <option value="3">
                                                3 - Cukup
                                            </option>

                                            <option value="4">
                                                4 - Baik
                                            </option>

                                            <option value="5">
                                                5 - Sangat Baik
                                            </option>

                                        </select>

                                        <button
                                            type="submit"
                                            class="btn btn-success mt-3"
                                        >
                                            Submit Rating
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

        </div>

    </section>


    <!-- ============================================
         FORUM DISKUSI
         ============================================ -->

    <section id="forum" class="section-padding section-animation">

        <div class="container">

            <h2 class="text-center mb-5">
                Forum Diskusi
            </h2>


            <!-- Form Komentar -->
            <div class="card">

                <div class="card-body">

                    <h5 class="card-title">
                        Diskusi Produk
                    </h5>

                    <form
                        method="POST"
                        action="?route=comment/store"
                    >

                        <?= csrf_field() ?>

                        <div class="mb-3">

                            <label
                                for="user-name"
                                class="form-label"
                            >
                                Nama
                            </label>

                            <input
                                type="text"
                                id="user-name"
                                name="name"
                                class="form-control"
                                placeholder="Masukkan nama Anda"
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="user-comment"
                                class="form-label"
                            >
                                Komentar
                            </label>

                            <textarea
                                id="user-comment"
                                name="comment"
                                class="form-control"
                                rows="4"
                                placeholder="Tulis komentar atau saran Anda..."
                                required
                            ></textarea>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Kirim
                        </button>

                    </form>

                </div>

            </div>


            <!-- Daftar Komentar -->
            <div class="mt-4">

                <h6>
                    Komunitas:
                </h6>

                <ul
                    id="comment-list"
                    class="list-group"
                >

                    <?php if (empty($comments)): ?>

                        <li class="list-group-item text-muted">
                            Belum ada komentar.
                        </li>

                    <?php else: ?>

                        <?php foreach ($comments as $comment): ?>

                            <li class="list-group-item">

                                <strong>
                                    <?= htmlspecialchars($comment['name']) ?>:
                                </strong>

                                <?= htmlspecialchars($comment['comment']) ?>

                            </li>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </ul>

            </div>

        </div>

    </section>


    <!-- ============================================
         KONTAK
         ============================================ -->

    <section id="kontak" class="section-padding section-animation">

        <div class="container">

            <h2 class="text-center mb-5">
                Hubungi Kami
            </h2>

            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <div class="contact-info">


                        <!-- Alamat -->
                        <div class="contact-item">

                            <i class="fas fa-map-marker-alt me-2"></i>

                            <span>
                                Central Square E-31, JL Ahmad Yani,
                                No. 41-43, Gedangan, Sidoarjo,
                                Jawa Timur, 61254, Indonesia
                            </span>

                        </div>


                        <!-- Telepon -->
                        <div class="contact-item">

                            <i class="fas fa-phone me-2"></i>

                            <span>
                                +62 31 8547202
                            </span>

                        </div>


                        <!-- Email -->
                        <div class="contact-item">

                            <i class="fas fa-envelope me-2"></i>

                            <span>
                                info@skmseafood.com
                            </span>

                        </div>


                        <!-- Jam Operasional -->
                        <div class="contact-item">

                            <i class="fas fa-clock me-2"></i>

                            <span>
                                Senin - Jumat: 08:00 - 17:00
                            </span>

                        </div>


                        <!-- Website -->
                        <div class="contact-item">

                            <i class="fas fa-globe me-2"></i>

                            <span>
                                www.freshfrozenfoodskm.com
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
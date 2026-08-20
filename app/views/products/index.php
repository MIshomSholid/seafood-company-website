<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<section class="section-padding">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-5">
            <h2 class="mb-0">Produk Kami</h2>

            <a href="?route=home#produk" class="btn btn-primary">
                <i class="fas fa-home me-2"></i>
                Beranda
            </a>
        </div>

        <div class="row">

            <?php if (empty($products)): ?>

                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Belum ada produk.
                    </div>
                </div>

            <?php else: ?>

                <?php foreach ($products as $product): ?>

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

                                <a href="?route=product/show&id=<?= (int) $product['id'] ?>" class="btn btn-primary">
                                    Detail Produk
                                </a>

                            </div>

                        </div>

                    </div>

                <?php endforeach; ?>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
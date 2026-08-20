<?php
require_once __DIR__ . '/../layouts/header.php';

$escape = static fn ($value): string => htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
?>

<section class="section-padding">
    <div class="container">
        <a href="?route=products" class="btn btn-outline-primary mb-4"><i class="fas fa-arrow-left me-1"></i>Kembali ke Produk</a>
        <div class="card product-card">
            <div class="row g-0">
                <div class="col-md-5">
                    <?php if (!empty($product['image'])): ?>
                        <img src="public/assets/images/<?= $escape(basename($product['image'])) ?>" class="img-fluid rounded-start w-100 h-100" style="object-fit: cover; min-height: 280px;" alt="<?= $escape($product['name']) ?>">
                    <?php else: ?>
                        <div class="bg-light d-flex align-items-center justify-content-center rounded-start" style="min-height: 280px;"><i class="fas fa-image text-muted" style="font-size: 60px;"></i></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-7">
                    <div class="card-body p-4">
                        <h1 class="h2 fw-bold"><?= $escape($product['name']) ?></h1>
                        <p><?= nl2br($escape($product['description'])) ?></p>
                        <p class="fw-semibold">Stok tersisa: <?= (int) $product['stock'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

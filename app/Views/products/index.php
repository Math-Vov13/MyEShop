<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5 fade-in">
    <h1><i class="fas fa-tags"></i> Nos Produits</h1>
    
    <div class="row mt-4">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <?php if ($product['image_url']): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light text-center py-5">
                            <i class="fas fa-gamepad fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($product['category_name']) ?></p>
                        <p class="card-text"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0"><?= number_format($product['price'], 2) ?> €</span>
                            <div>
                                <a href="/products/<?= $product['id'] ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-info-circle"></i> Détails
                                </a>
                                <form action="/cart/add" method="POST" class="d-inline">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-cart-plus"></i> Ajouter
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
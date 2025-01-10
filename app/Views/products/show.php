<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/">Accueil</a></li>
            <li class="breadcrumb-item"><a href="/products">Produits</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($product['name']) ?></li>
        </ol>
    </nav>

    <div class="row">
        <!-- Image du produit -->
        <div class="col-md-6">
            <div class="card">
                <?php if ($product['image_url']): ?>
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <div class="card-img-top bg-light text-center py-5">
                        <i class="fas fa-gamepad fa-4x text-muted"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Informations du produit -->
        <div class="col-md-6">
            <h1 class="mb-3"><?= htmlspecialchars($product['name']) ?></h1>
            
            <div class="mb-3">
                <div class="d-flex align-items-center">
                    <?php
                    $rating = $product['rating'] ?? 0;
                    $reviewCount = $product['review_count'] ?? 0;
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $rating) {
                            echo '<i class="fas fa-star text-warning"></i>';
                        } else {
                            echo '<i class="far fa-star text-warning"></i>';
                        }
                    }
                    ?>
                    <span class="ms-2"><?= $reviewCount ?> avis</span>
                </div>
            </div>

            <div class="mb-4">
                <?php if (isset($product['discount']) && $product['discount'] > 0): ?>
                    <div class="text-decoration-line-through text-muted">
                        <?= number_format($product['price'], 2) ?> €
                    </div>
                    <div class="h2 text-danger">
                        <?= number_format($product['price'] * (1 - $product['discount']/100), 2) ?> €
                    </div>
                <?php else: ?>
                    <div class="h2"><?= number_format($product['price'], 2) ?> €</div>
                <?php endif; ?>
            </div>

            <div class="mb-4">
                <?php if ($product['stock'] > 0): ?>
                    <div class="text-success mb-3">
                        <i class="fas fa-check-circle"></i> En stock
                    </div>
                <?php else: ?>
                    <div class="text-danger mb-3">
                        <i class="fas fa-times-circle"></i> Rupture de stock
                    </div>
                <?php endif; ?>

                <?php if ($product['stock'] > 0): ?>
                    <form action="/cart/add" method="POST" class="d-flex align-items-center">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <input type="number" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>" class="form-control me-2" style="width: 80px;">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Ajouter au panier
                        </button>
                    </form>
                <?php endif; ?>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Détails du produit</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td class="text-muted">Plateforme:</td>
                            <td><?= htmlspecialchars($product['platform'] ?? 'Non spécifié') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Genre:</td>
                            <td><?= htmlspecialchars($product['genre'] ?? 'Non spécifié') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Éditeur:</td>
                            <td><?= htmlspecialchars($product['publisher'] ?? 'Non spécifié') ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted">Date de sortie:</td>
                            <td><?= isset($product['release_date']) ? date('d/m/Y', strtotime($product['release_date'])) : 'Non spécifié' ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des avis -->
    <div class="row mt-5">
        <div class="col-12">
            <h2 class="mb-4">Avis clients</h2>
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center">
                            <h1 class="display-4"><?= number_format($product['rating'] ?? 0, 1) ?></h1>
                            <div class="mb-2">
                                <?php
                                $rating = $product['rating'] ?? 0;
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="fas fa-star text-warning"></i>';
                                    } else {
                                        echo '<i class="far fa-star text-warning"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <p class="text-muted"><?= $product['review_count'] ?? 0 ?> avis</p>
                        </div>
                        <div class="col-md-8">
                            <!-- Ici vous pouvez ajouter une répartition des notes si nécessaire -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
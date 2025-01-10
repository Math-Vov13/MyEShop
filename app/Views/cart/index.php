<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-shopping-cart"></i> Mon Panier
    </h1>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> Votre panier est vide.
            <a href="/products" class="alert-link">Découvrez nos produits</a>
        </div>
    <?php else: ?>
        <div class="row">
            <!-- Liste des produits -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="row mb-4 align-items-center">
                                <!-- Image -->
                                <div class="col-md-2">
                                    <?php if ($item['product']['image_url']): ?>
                                        <img src="<?= htmlspecialchars($item['product']['image_url']) ?>" 
                                             class="img-fluid rounded" 
                                             alt="<?= htmlspecialchars($item['product']['name']) ?>">
                                    <?php else: ?>
                                        <div class="bg-light text-center p-3 rounded">
                                            <i class="fas fa-gamepad fa-2x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- Informations produit -->
                                <div class="col-md-4">
                                    <h5><?= htmlspecialchars($item['product']['name']) ?></h5>
                                    <p class="text-muted mb-0">
                                        <?php if (isset($item['product']['platform'])): ?>
                                            <small><?= htmlspecialchars($item['product']['platform']) ?></small>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                
                                <!-- Quantité -->
                                <div class="col-md-3">
                                    <form action="/cart/update" method="POST" class="d-flex align-items-center">
                                        <input type="hidden" name="product_id" value="<?= $item['product']['id'] ?>">
                                        <input type="number" 
                                               name="quantity" 
                                               value="<?= $item['quantity'] ?>" 
                                               min="1" 
                                               max="<?= $item['product']['stock'] ?>" 
                                               class="form-control form-control-sm" 
                                               style="width: 70px;"
                                               onchange="this.form.submit()">
                                    </form>
                                </div>
                                
                                <!-- Prix et actions -->
                                <div class="col-md-3">
                                    <div class="text-end">
                                        <?php if (isset($item['product']['discount']) && $item['product']['discount'] > 0): ?>
                                            <div class="text-decoration-line-through text-muted">
                                                <small><?= number_format($item['product']['price'] * $item['quantity'], 2) ?> €</small>
                                            </div>
                                            <div class="text-danger">
                                                <?= number_format($item['subtotal'], 2) ?> €
                                            </div>
                                        <?php else: ?>
                                            <div><?= number_format($item['subtotal'], 2) ?> €</div>
                                        <?php endif; ?>
                                        
                                        <form action="/cart/remove" method="POST" class="mt-2">
                                            <input type="hidden" name="product_id" value="<?= $item['product']['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Code Promo -->
                <div class="card mt-3">
                    <div class="card-body">
                        <?php if (isset($_SESSION['promo_success'])): ?>
                            <div class="alert alert-success">
                                <?= $_SESSION['promo_success'] ?>
                                <?php unset($_SESSION['promo_success']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['promo_error'])): ?>
                            <div class="alert alert-danger">
                                <?= $_SESSION['promo_error'] ?>
                                <?php unset($_SESSION['promo_error']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['promo_code'])): ?>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Code promo appliqué :</strong> 
                                    <?= htmlspecialchars($_SESSION['promo_code']) ?>
                                    <span class="text-success">(-<?= number_format($discount, 2) ?> €)</span>
                                </div>
                                <form action="/cart/remove-promo" method="POST">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-times"></i> Retirer
                                    </button>
                                </form>
                            </div>
                        <?php else: ?>
                            <form action="/cart/apply-promo" method="POST" class="d-flex gap-2">
                                <input type="text" 
                                       name="promo_code" 
                                       class="form-control" 
                                       placeholder="Entrez votre code promo"
                                       required>
                                <button type="submit" class="btn btn-primary">
                                    Appliquer
                                </button>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Résumé de la commande -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Résumé de la commande</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3">
                            <span>Sous-total</span>
                            <span><?= number_format($total + $discount, 2) ?> €</span>
                        </div>
                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Réduction</span>
                                <span class="text-success">-<?= number_format($discount, 2) ?> €</span>
                            </div>
                        <?php endif; ?>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Livraison</span>
                            <span class="text-success">Gratuite</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-4">
                            <strong>Total</strong>
                            <strong><?= number_format($total, 2) ?> €</strong>
                        </div>
                        
                        <a href="/checkout" class="btn btn-primary w-100 mb-2">
                            <i class="fas fa-lock me-2"></i> Procéder au paiement
                        </a>
                        
                        <a href="/products" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-arrow-left me-2"></i> Continuer mes achats
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <h1 class="mb-4">
        <i class="fas fa-credit-card"></i> Paiement
    </h1>

    <?php if (isset($_SESSION['checkout_error'])): ?>
        <div class="alert alert-danger">
            <?= $_SESSION['checkout_error'] ?>
            <?php unset($_SESSION['checkout_error']); ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire de paiement -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="/checkout/process" method="POST" id="checkout-form">
                        <h5 class="card-title mb-4">Informations de livraison</h5>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName" class="form-label">Prénom</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName" class="form-label">Nom</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Adresse</label>
                            <input type="text" class="form-control" id="address" name="address" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">Ville</label>
                                <input type="text" class="form-control" id="city" name="city" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="postalCode" class="form-label">Code postal</label>
                                <input type="text" class="form-control" id="postalCode" name="postalCode" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="country" class="form-label">Pays</label>
                                <select class="form-select" id="country" name="country" required>
                                    <option value="">Choisir...</option>
                                    <option value="FR">France</option>
                                    <option value="BE">Belgique</option>
                                    <option value="CH">Suisse</option>
                                    <option value="LU">Luxembourg</option>
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="card-title mb-4">Paiement</h5>
                        <div id="card-element" class="mb-3">
                            <!-- Un élément Stripe sera inséré ici -->
                        </div>

                        <button class="btn btn-primary w-100" type="submit">
                            <i class="fas fa-lock me-2"></i> Payer <?= number_format($total, 2) ?> €
                        </button>
                    </form>
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
                    <?php foreach ($cart_items as $item): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                <?= htmlspecialchars($item['product']['name']) ?>
                                <small class="text-muted">x<?= $item['quantity'] ?></small>
                            </span>
                            <span><?= number_format($item['subtotal'], 2) ?> €</span>
                        </div>
                    <?php endforeach; ?>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total</span>
                        <span><?= number_format($total + $discount, 2) ?> €</span>
                    </div>

                    <?php if ($discount > 0): ?>
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                Code promo 
                                <small class="text-muted">(<?= htmlspecialchars($_SESSION['promo_code']) ?>)</small>
                            </span>
                            <span class="text-success">-<?= number_format($discount, 2) ?> €</span>
                        </div>
                    <?php endif; ?>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Livraison</span>
                        <span class="text-success">Gratuite</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <strong>Total</strong>
                        <strong><?= number_format($total, 2) ?> €</strong>
                    </div>

                    <?php if ($discount > 0): ?>
                        <div class="mt-2">
                            <small class="text-success">
                                Vous économisez <?= number_format($discount, 2) ?> € grâce au code promo !
                            </small>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
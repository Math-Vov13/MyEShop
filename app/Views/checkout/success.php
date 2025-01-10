<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.success-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 30px 20px;
}

.order-details {
    margin-top: 30px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f8f9fa;
}

.order-number {
    font-size: 1.2em;
    color: #2c3e50;
    margin-bottom: 20px;
    padding: 10px;
    background-color: #e9ecef;
    border-radius: 5px;
}

.detail-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    padding: 5px 0;
    border-bottom: 1px solid #eee;
}

.detail-row:last-child {
    border-bottom: none;
}

.success-icon {
    color: #28a745;
    animation: scaleUp 0.5s ease-in-out;
}

@keyframes scaleUp {
    0% { transform: scale(0); }
    80% { transform: scale(1.2); }
    100% { transform: scale(1); }
}
</style>

<div class="container mt-5">
    <div class="success-container">
        <div class="text-center mb-5">
            <div class="mb-4">
                <i class="fas fa-check-circle success-icon" style="font-size: 64px;"></i>
            </div>
            
            <h1 class="mb-4">Merci pour votre commande !</h1>
            
            <div class="alert alert-success d-inline-block">
                <p class="mb-0">Votre commande a été traitée avec succès.</p>
            </div>
            
            <p class="mt-4">Un email de confirmation vous a été envoyé à <?= htmlspecialchars($orderData['email']) ?></p>
        </div>

        <div class="order-details">
            <div class="order-number">
                Commande #<?= htmlspecialchars($orderData['orderNumber']) ?>
            </div>

            <div class="customer-info mb-4">
                <h5>Informations de livraison</h5>
                <div class="detail-row">
                    <span>Nom</span>
                    <span><?= htmlspecialchars($orderData['firstName'] . ' ' . $orderData['lastName'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="detail-row">
                    <span>Adresse</span>
                    <span><?= htmlspecialchars($orderData['address']) ?></span>
                </div>
                <div class="detail-row">
                    <span>Ville</span>
                    <span><?= htmlspecialchars($orderData['city'] . ' ' . $orderData['postalCode']) ?></span>
                </div>
                <div class="detail-row">
                    <span>Pays</span>
                    <span><?= htmlspecialchars($orderData['country']) ?></span>
                </div>
            </div>

            <div class="order-summary">
                <h5>Résumé de la commande</h5>
                <?php foreach ($orderData['cart_items'] as $item): ?>
                    <div class="detail-row">
                        <span>
                            <?= htmlspecialchars($item['product']['name']) ?>
                            <small class="text-muted">x<?= $item['quantity'] ?></small>
                        </span>
                        <span><?= number_format($item['subtotal'], 2) ?> €</span>
                    </div>
                <?php endforeach; ?>

                <div class="detail-row">
                    <span>Sous-total</span>
                    <span><?= number_format($orderData['subtotal'], 2) ?> €</span>
                </div>

                <?php if ($orderData['discount'] > 0): ?>
                    <div class="detail-row">
                        <span>Réduction</span>
                        <span class="text-success">-<?= number_format($orderData['discount'], 2) ?> €</span>
                    </div>
                <?php endif; ?>

                <div class="detail-row">
                    <span>Livraison</span>
                    <span class="text-success">Gratuite</span>
                </div>

                <div class="detail-row">
                    <strong>Total</strong>
                    <strong><?= number_format($orderData['total'], 2) ?> €</strong>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="/products" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>
                Continuer mes achats
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
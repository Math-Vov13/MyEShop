<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<style>
.processing-container {
    text-align: center;
    padding: 50px 20px;
}

.spinner {
    width: 70px;
    height: 70px;
    border: 8px solid #f3f3f3;
    border-top: 8px solid #3498db;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.order-details {
    max-width: 600px;
    margin: 30px auto;
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

.processing-steps {
    max-width: 400px;
    margin: 20px auto;
    text-align: left;
}

.step {
    margin: 10px 0;
    padding: 10px;
    border-radius: 5px;
    background-color: #f8f9fa;
    transition: background-color 0.3s;
}

.step.active {
    background-color: #e3f2fd;
    border-left: 4px solid #3498db;
}

.step.completed {
    background-color: #e8f5e9;
    border-left: 4px solid #4caf50;
}
</style>

<div class="container mt-5">
    <div class="processing-container">
        <h1 class="mb-4">Traitement de votre commande</h1>
        
        <div class="spinner"></div>
        
        <div class="processing-steps">
            <div class="step active" id="step1">
                <i class="fas fa-check-circle me-2"></i> Vérification des informations
            </div>
            <div class="step" id="step2">
                <i class="fas fa-credit-card me-2"></i> Traitement du paiement
            </div>
            <div class="step" id="step3">
                <i class="fas fa-box me-2"></i> Préparation de la commande
            </div>
        </div>

        <div class="order-details">
            <div class="order-number">
                Commande #<?= $orderNumber ?>
            </div>

            <div class="customer-info mb-4">
                <h5>Informations client</h5>
                <div class="detail-row">
                    <span>Nom</span>
                    <span><?= htmlspecialchars($firstName . ' ' . $lastName) ?></span>
                </div>
                <div class="detail-row">
                    <span>Email</span>
                    <span><?= htmlspecialchars($email) ?></span>
                </div>
                <div class="detail-row">
                    <span>Adresse</span>
                    <span><?= htmlspecialchars($address) ?></span>
                </div>
                <div class="detail-row">
                    <span>Ville</span>
                    <span><?= htmlspecialchars($city . ' ' . $postalCode) ?></span>
                </div>
            </div>

            <div class="order-summary">
                <h5>Résumé de la commande</h5>
                <?php foreach ($cart_items as $item): ?>
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
                    <span><?= number_format($subtotal, 2) ?> €</span>
                </div>

                <?php if ($discount > 0): ?>
                    <div class="detail-row">
                        <span>Réduction (<?= htmlspecialchars($_SESSION['promo_code']) ?>)</span>
                        <span class="text-success">-<?= number_format($discount, 2) ?> €</span>
                    </div>
                <?php endif; ?>

                <div class="detail-row">
                    <span>Livraison</span>
                    <span class="text-success">Gratuite</span>
                </div>

                <div class="detail-row">
                    <strong>Total</strong>
                    <strong><?= number_format($total, 2) ?> €</strong>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Simulation des étapes de traitement
    setTimeout(() => {
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step1').classList.add('completed');
        document.getElementById('step2').classList.add('active');
    }, 2000);

    setTimeout(() => {
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step2').classList.add('completed');
        document.getElementById('step3').classList.add('active');
    }, 4000);

    // Redirection vers la page de succès après 6 secondes
    setTimeout(() => {
        document.getElementById('step3').classList.remove('active');
        document.getElementById('step3').classList.add('completed');
        window.location.href = '/checkout/success';
    }, 6000);
});
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
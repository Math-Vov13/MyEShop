<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container mt-5">
    <div class="text-center">
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
        </div>
        
        <h1 class="mb-4">Merci pour votre commande !</h1>
        
        <div class="alert alert-success d-inline-block">
            <p class="mb-0">Votre commande a été traitée avec succès.</p>
        </div>
        
        <p class="mt-4">Un email de confirmation vous a été envoyé avec les détails de votre commande.</p>
        
        <div class="mt-4">
            <a href="/products" class="btn btn-primary">
                <i class="fas fa-shopping-bag me-2"></i>
                Continuer mes achats
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<div class="container fade-in">
    <div class="hero-section">
        <h1><i class="fas fa-star"></i> Bienvenue sur "MyEShop"</h1>
        <p>Découvrez notre sélection de produits exceptionnels</p>
        <a href="/products" class="btn btn-light btn-lg"><i class="fas fa-shopping-bag"></i> Découvrir nos produits</a>
    </div>

    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-truck fa-3x mb-3 text-primary"></i>
                    <h3>Livraison rapide</h3>
                    <p>Livraison gratuite à partir de 50€ d'achat</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-lock fa-3x mb-3 text-primary"></i>
                    <h3>Paiement sécurisé</h3>
                    <p>Vos transactions sont 100% sécurisées</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-headset fa-3x mb-3 text-primary"></i>
                    <h3>Service client</h3>
                    <p>Une équipe à votre écoute 7j/7</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <div class="col-md-6">
            <h2><i class="fas fa-fire"></i> Nos derniers produits</h2>
            <p>Explorez notre sélection de produits de qualité soigneusement choisis pour vous.</p>
            <a href="/products" class="btn btn-primary">
                <i class="fas fa-arrow-right"></i> Voir tous les produits
            </a>
        </div>
        <div class="col-md-6">
            <h2><i class="fas fa-percent"></i> Offres spéciales</h2>
            <p>Ne manquez pas nos promotions exclusives et nos offres limitées.</p>
            <a href="/products" class="btn btn-primary">
                <i class="fas fa-tags"></i> Voir les offres
            </a>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
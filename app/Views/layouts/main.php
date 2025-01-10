<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'MyEShop' ?></title>
    <meta name="description" content="<?= $description ?? 'Votre boutique de jeux vidéo nouvelle génération' ?>">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/css/normalize.css">
    <link rel="stylesheet" href="/css/style.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <nav class="navbar">
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <img src="/assets/images/logo.png" alt="MyEShop Logo">
                </a>
            </div>
            
            <div class="navbar-menu">
                <ul class="nav-links">
                    <li><a href="/">Accueil</a></li>
                    <li><a href="/products">Produits</a></li>
                    <li><a href="/categories">Catégories</a></li>
                    <li><a href="/about">À propos</a></li>
                    <li><a href="/contact">Contact</a></li>
                </ul>
            </div>
            
            <div class="navbar-end">
                <div class="search-bar">
                    <form action="/search" method="GET">
                        <input type="text" name="q" placeholder="Rechercher...">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>
                
                <div class="user-menu">
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/account" class="account-link">
                            <i class="fas fa-user"></i>
                            <span>Mon compte</span>
                        </a>
                    <?php else: ?>
                        <a href="/login" class="login-link">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Connexion</span>
                        </a>
                    <?php endif; ?>
                </div>
                
                <div class="cart-menu">
                    <a href="/cart" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?= $cartCount ?? 0 ?></span>
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="flash-messages">
                <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                    <div class="alert alert-<?= $type ?>">
                        <?= $message ?>
                    </div>
                <?php endforeach; ?>
                <?php unset($_SESSION['flash']); ?>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>À propos de MyEShop</h3>
                <p>Votre destination gaming de confiance pour une expérience de jeu nouvelle génération.</p>
            </div>
            
            <div class="footer-section">
                <h3>Liens rapides</h3>
                <ul>
                    <li><a href="/about">À propos</a></li>
                    <li><a href="/contact">Contact</a></li>
                    <li><a href="/faq">FAQ</a></li>
                    <li><a href="/shipping">Livraison</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Service client</h3>
                <ul>
                    <li><a href="/returns">Retours</a></li>
                    <li><a href="/terms">Conditions générales</a></li>
                    <li><a href="/privacy">Politique de confidentialité</a></li>
                    <li><a href="/support">Support</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Suivez-nous</h3>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> MyEShop. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="/js/main.js"></script>
    <?php if (isset($scripts)): ?>
        <?php foreach ($scripts as $script): ?>
            <script src="<?= $script ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
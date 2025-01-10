<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Gestion des erreurs en développement
if ($_ENV['APP_ENV'] === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Démarrer la session
session_start();

// Router simple
$request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Routes
switch ($request) {
    case '/':
        require __DIR__ . '/../app/Controllers/HomeController.php';
        $controller = new \App\Controllers\HomeController();
        $controller->index();
        break;
        
    case '/products':
        require __DIR__ . '/../app/Controllers/ProductController.php';
        $controller = new \App\Controllers\ProductController();
        $controller->index();
        break;
        
    case (preg_match('/^\/products\/(\d+)$/', $request, $matches) ? true : false):
        require __DIR__ . '/../app/Controllers/ProductController.php';
        $controller = new \App\Controllers\ProductController();
        $controller->show($matches[1]);
        break;
        
    case '/cart':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->index();
        break;
        
    case '/cart/add':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->add();
        break;
        
    case '/cart/update':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->update();
        break;
        
    case '/cart/remove':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->remove();
        break;
        
    case '/cart/clear':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->clear();
        break;

    case '/cart/apply-promo':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->applyPromo();
        break;

    case '/cart/remove-promo':
        require __DIR__ . '/../app/Controllers/CartController.php';
        $controller = new \App\Controllers\CartController();
        $controller->removePromo();
        break;
        
    case '/checkout':
        require __DIR__ . '/../app/Controllers/CheckoutController.php';
        $controller = new \App\Controllers\CheckoutController();
        $controller->index();
        break;

    case '/checkout/process':
        require __DIR__ . '/../app/Controllers/CheckoutController.php';
        $controller = new \App\Controllers\CheckoutController();
        $controller->process();
        break;

    case '/checkout/success':
        require __DIR__ . '/../app/Controllers/CheckoutController.php';
        $controller = new \App\Controllers\CheckoutController();
        $controller->success();
        break;
        
    default:
        http_response_code(404);
        require __DIR__ . '/../app/Views/404.php';
        break;
}
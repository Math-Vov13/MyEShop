<?php

namespace App\Controllers;

use App\Config\Database;

class CartController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        
        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Initialiser le panier s'il n'existe pas
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index()
    {
        $cart_items = [];
        $total = 0;
        $discount = 0;
        $promoCode = isset($_SESSION['promo_code']) ? $_SESSION['promo_code'] : null;
        
        // Récupérer les informations des produits dans le panier
        if (!empty($_SESSION['cart'])) {
            $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
            $product_ids = array_keys($_SESSION['cart']);
            
            $stmt = $this->db->prepare("
                SELECT * FROM products 
                WHERE id IN ($placeholders)
            ");
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Calculer le total et préparer les données pour la vue
            foreach ($products as $product) {
                $quantity = $_SESSION['cart'][$product['id']];
                $subtotal = $product['price'] * $quantity;
                
                // Appliquer la réduction si elle existe
                if (isset($product['discount']) && $product['discount'] > 0) {
                    $subtotal = $subtotal * (1 - $product['discount'] / 100);
                }
                
                $cart_items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal
                ];
                
                $total += $subtotal;
            }

            // Appliquer le code promo si présent
            if ($promoCode) {
                $stmt = $this->db->prepare("
                    SELECT * FROM promo_codes 
                    WHERE code = ? 
                    AND active = true 
                    AND start_date <= NOW() 
                    AND end_date >= NOW()
                ");
                $stmt->execute([$promoCode]);
                $promo = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($promo) {
                    $discount = $total * ($promo['discount_percent'] / 100);
                    $total -= $discount;
                }
            }
        }
        
        // Charger la vue du panier
        require __DIR__ . '/../Views/cart/index.php';
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            
            if ($product_id && $quantity > 0) {
                // Vérifier si le produit existe et s'il y a assez de stock
                $stmt = $this->db->prepare("SELECT stock FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $product = $stmt->fetch();
                
                if ($product && $product['stock'] >= $quantity) {
                    // Ajouter ou mettre à jour la quantité dans le panier
                    if (isset($_SESSION['cart'][$product_id])) {
                        $_SESSION['cart'][$product_id] += $quantity;
                    } else {
                        $_SESSION['cart'][$product_id] = $quantity;
                    }
                    
                    // Rediriger vers le panier avec un message de succès
                    header('Location: /cart');
                    exit;
                }
            }
        }
        
        // En cas d'erreur, rediriger vers la page précédente
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            
            if ($product_id && $quantity >= 0) {
                if ($quantity === 0) {
                    unset($_SESSION['cart'][$product_id]);
                } else {
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            }
        }
        
        header('Location: /cart');
        exit;
    }

    public function remove()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            
            if ($product_id && isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
            }
        }
        
        header('Location: /cart');
        exit;
    }

    public function clear()
    {
        $_SESSION['cart'] = [];
        unset($_SESSION['promo_code']);
        header('Location: /cart');
        exit;
    }

    public function applyPromo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $code = filter_input(INPUT_POST, 'promo_code', FILTER_SANITIZE_STRING);
            
            if ($code) {
                $stmt = $this->db->prepare("
                    SELECT * FROM promo_codes 
                    WHERE code = ? 
                    AND active = true 
                    AND start_date <= NOW() 
                    AND end_date >= NOW()
                ");
                $stmt->execute([$code]);
                $promo = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($promo) {
                    $_SESSION['promo_code'] = $code;
                    $_SESSION['promo_success'] = "Code promo appliqué avec succès !";
                } else {
                    $_SESSION['promo_error'] = "Code promo invalide ou expiré.";
                }
            }
        }
        
        header('Location: /cart');
        exit;
    }

    public function removePromo()
    {
        unset($_SESSION['promo_code']);
        header('Location: /cart');
        exit;
    }
}
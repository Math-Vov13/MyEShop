<?php

namespace App\Controllers;

use App\Config\Database;

class CheckoutController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();

        // Démarrer la session si elle n'est pas déjà démarrée
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Rediriger vers la page d'accueil si le panier est vide
        if (empty($_SESSION['cart'])) {
            header('Location: /cart');
            exit;
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

                // Appliquer la réduction si elle existe sur le produit
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

        // Charger la vue du checkout
        require __DIR__ . '/../Views/checkout/index.php';
    }

    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /checkout');
            exit;
        }

        // Validation des données du formulaire
        $firstName = filter_var($_POST['firstName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $lastName = filter_var($_POST['lastName'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
        $address = filter_var($_POST['address'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $city = filter_var($_POST['city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $postalCode = filter_var($_POST['postalCode'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!$firstName || !$lastName || !$email || !$address || !$city || !$postalCode || !$country) {
            $_SESSION['checkout_error'] = "Veuillez remplir tous les champs obligatoires.";
            header('Location: /checkout');
            exit;
        }

        // Récupérer les informations du panier
        $cart_items = [];
        $total = 0;
        $discount = 0;
        $subtotal = 0;
        $promoCode = isset($_SESSION['promo_code']) ? $_SESSION['promo_code'] : null;

        if (!empty($_SESSION['cart'])) {
            $placeholders = str_repeat('?,', count($_SESSION['cart']) - 1) . '?';
            $product_ids = array_keys($_SESSION['cart']);

            $stmt = $this->db->prepare("
                SELECT * FROM products
                WHERE id IN ($placeholders)
            ");
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                $quantity = $_SESSION['cart'][$product['id']];
                $itemSubtotal = $product['price'] * $quantity;

                if (isset($product['discount']) && $product['discount'] > 0) {
                    $itemSubtotal = $itemSubtotal * (1 - $product['discount'] / 100);
                }

                $cart_items[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $itemSubtotal
                ];

                $subtotal += $itemSubtotal;
            }

            $total = $subtotal;

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

        // Générer un numéro de commande unique
        $orderNumber = 'CMD' . date('Ymd') . strtoupper(substr(uniqid(), -5));

        // Enregistrer la commande dans la base de données
        $stmt = $this->db->prepare("
            INSERT INTO orders (
                order_number, first_name, last_name, email,
                address, city, postal_code, country,
                total_amount, discount_amount, promo_code
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $orderNumber, $firstName, $lastName, $email,
            $address, $city, $postalCode, $country,
            $total, $discount, $promoCode
        ]);

        // Stocker les informations de commande en session pour la page de traitement
        $_SESSION['processing_order'] = [
            'orderNumber' => $orderNumber,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'address' => $address,
            'city' => $city,
            'postalCode' => $postalCode,
            'country' => $country,
            'cart_items' => $cart_items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $total
        ];

        // Afficher la page de traitement
        extract($_SESSION['processing_order']);
        require __DIR__ . '/../Views/checkout/processing.php';
    }

    public function success()
    {
        if (!isset($_SESSION['processing_order'])) {
            header('Location: /cart');
            exit;
        }

        $orderData = $_SESSION['processing_order'];

        // Vider le panier et les données de commande
        $_SESSION['cart'] = [];
        unset($_SESSION['promo_code']);
        unset($_SESSION['processing_order']);

        require __DIR__ . '/../Views/checkout/success.php';
    }
}

<?php

namespace App\Controllers;

use App\Config\Database;

class ProductController extends BaseController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function index()
    {
        try {
            $stmt = $this->db->query("SELECT p.*, c.name as category_name 
                                    FROM products p 
                                    LEFT JOIN categories c ON p.category_id = c.id");
            $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);
            
            // Inclure la vue avec les produits
            require __DIR__ . '/../Views/products/index.php';
        } catch (\PDOException $e) {
            // En cas d'erreur, afficher un message d'erreur
            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }

    public function show($id)
    {
        try {
            $stmt = $this->db->prepare("SELECT p.*, c.name as category_name 
                                       FROM products p 
                                       LEFT JOIN categories c ON p.category_id = c.id 
                                       WHERE p.id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$product) {
                http_response_code(404);
                require __DIR__ . '/../Views/404.php';
                return;
            }
            
            require __DIR__ . '/../Views/products/show.php';
        } catch (\PDOException $e) {
            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
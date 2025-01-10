<?php

namespace App\Config;

class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        try {
            // Venv
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $port = getenv('DB_PORT') ?: '3306';
            $dbname = getenv('DB_NAME') ?: 'myeshop_db';
            $user = getenv('DB_USER') ?: 'root';
            $pass = getenv('DB_PASSWORD') ?: 'root';

            // Url
            $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";

            // Options de connexion
            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
            ];

            // Tentative de connexion
            $this->connection = new \PDO($dsn, $user, $pass, $options);

            // Test de la connexion
            $this->connection->query('SELECT 1');
            
        } catch(\PDOException $e) {
            // Affichage détaillé de l'erreur pour le débogage
            error_log("Erreur de connexion PDO: " . $e->getMessage());
            error_log("DSN utilisé: $dsn");
            error_log("Utilisateur: $user");
            die("Erreur de connexion à la base de données: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}
<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// Paramètres de connexion
$host = $_ENV['DB_HOST'];
$port = $_ENV['DB_PORT'] ?: '3306';
$dbname = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];

try {
    // Connexion au serveur MySQL
    $dsn = "mysql:host=$host;port=$port";
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
    
    // Création de la base de données
    $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
    $pdo->exec("CREATE DATABASE `$dbname`");
    echo "Base de données créée ou déjà existante.\n";
    
    // Sélection de la base de données
    $pdo->exec("USE `$dbname`");
    
    // Lecture et exécution de tous les fichiers de migration dans l'ordre
    $migrations = [
        '001_initial_schema.sql',
        '002_promo_codes.sql',
        '003_orders.sql'
    ];

    foreach ($migrations as $migration) {
        $sql = file_get_contents(__DIR__ . '/../database/migrations/' . $migration);
        if ($sql === false) {
            throw new Exception("Impossible de lire le fichier de migration: $migration");
        }
        $pdo->exec($sql);
        echo "Migration $migration exécutée avec succès.\n";
    }
    
    echo "Données de test insérées.\n";
    echo "Initialisation de la base de données terminée avec succès!\n";
    
} catch(Exception $e) {
    die("Erreur : " . $e->getMessage() . "\n");
}
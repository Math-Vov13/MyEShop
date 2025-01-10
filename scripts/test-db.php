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
$socket = $_ENV['DB_SOCKET'] ?: null;

echo "Test de connexion à la base de données...\n";
echo "Host: $host\n";
echo "Port: $port\n";
echo "Database: $dbname\n";
echo "User: $user\n";
echo "Socket: $socket\n\n";

try {
    // Essai avec le socket si disponible
    if ($socket && file_exists($socket)) {
        $dsn = "mysql:unix_socket=$socket;dbname=$dbname";
        echo "Tentative de connexion via socket...\n";
    } else {
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname";
        echo "Tentative de connexion via TCP...\n";
    }

    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    
    // Test simple
    $stmt = $pdo->query('SELECT 1');
    echo "Connexion réussie!\n";
    
    // Test de lecture des tables
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "\nTables trouvées:\n";
    foreach ($tables as $table) {
        echo "- $table\n";
    }
    
} catch(PDOException $e) {
    echo "Erreur de connexion: " . $e->getMessage() . "\n";
    
    // Vérifications supplémentaires
    echo "\nVérifications:\n";
    if ($socket) {
        echo "Socket existe: " . (file_exists($socket) ? "Oui" : "Non") . "\n";
    }
    echo "MySQL est en cours d'exécution: " . (shell_exec("ps aux | grep mysql | grep -v grep") ? "Oui" : "Non") . "\n";
}
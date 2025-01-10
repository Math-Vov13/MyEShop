<?php

// Vérifier que le script est exécuté en CLI
if (php_sapi_name() !== 'cli') {
    die('Ce script ne peut être exécuté qu\'en ligne de commande');
}

// Fonction pour afficher des messages colorés dans le terminal
function console_log($message, $type = 'info') {
    $colors = [
        'error' => "\033[31m", // Rouge
        'success' => "\033[32m", // Vert
        'info' => "\033[36m", // Cyan
        'reset' => "\033[0m"  // Reset
    ];

    echo $colors[$type] . $message . $colors['reset'] . PHP_EOL;
}

// Charger les variables d'environnement depuis le fichier .env
function loadEnv() {
    $envFile = __DIR__ . '/../.env';
    if (!file_exists($envFile)) {
        console_log("Erreur : Fichier .env non trouvé!", 'error');
        console_log("Veuillez créer un fichier .env avec les informations de connexion à la base de données.", 'info');
        exit(1);
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);
            putenv("$key=$value");
            $_ENV[$key] = $value;
        }
    }
}

// Tester la connexion à la base de données
function testDatabaseConnection() {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');

    console_log("Tentative de connexion à la base de données...", 'info');
    console_log("Host: $host", 'info');
    console_log("Database: $dbname", 'info');
    console_log("User: $user", 'info');

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);
        console_log("✓ Connexion réussie à la base de données!", 'success');

        // Tester la version de MySQL
        $version = $pdo->query('SELECT VERSION() as version')->fetch();
        console_log("Version MySQL: " . $version['version'], 'info');

        // Lister les tables
        $tables = $pdo->query('SHOW TABLES')->fetchAll();
        if (count($tables) > 0) {
            console_log("\nTables trouvées dans la base de données:", 'info');
            foreach ($tables as $table) {
                console_log("- " . reset($table), 'info');
            }
        } else {
            console_log("\nAucune table trouvée dans la base de données.", 'info');
        }

        return true;
    } catch (PDOException $e) {
        console_log("✗ Erreur de connexion: " . $e->getMessage(), 'error');
        return false;
    }
}

// Exécution principale
console_log("\n=== Test de connexion à la base de données ===\n", 'info');

// Charger les variables d'environnement
loadEnv();

// Tester la connexion
if (testDatabaseConnection()) {
    exit(0); // Succès
} else {
    exit(1); // Erreur
}
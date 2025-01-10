<?php

if (php_sapi_name() !== 'cli') {
    die('Ce script ne peut être exécuté qu\'en ligne de commande');
}

// Fonction pour afficher des messages colorés
function console_log($message, $type = 'info') {
    $colors = [
        'error' => "\033[31m",
        'success' => "\033[32m",
        'info' => "\033[36m",
        'warning' => "\033[33m",
        'reset' => "\033[0m"
    ];

    echo $colors[$type] . $message . $colors['reset'] . PHP_EOL;
}

// Charger les variables d'environnement
function loadEnv() {
    $envFile = __DIR__ . '/../.env';
    if (!file_exists($envFile)) {
        console_log("Erreur : Fichier .env non trouvé!", 'error');
        exit(1);
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            putenv(trim($key) . "=" . trim($value));
        }
    }
}

// Connexion à la base de données
function getConnection() {
    $host = getenv('DB_HOST');
    $dbname = getenv('DB_NAME');
    $user = getenv('DB_USER');
    $pass = getenv('DB_PASSWORD');

    try {
        $dsn = "mysql:host=$host;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        console_log("Erreur de connexion: " . $e->getMessage(), 'error');
        exit(1);
    }
}

// Créer la base de données
function createDatabase() {
    $pdo = getConnection();
    $dbname = getenv('DB_NAME');

    try {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        console_log("Base de données '$dbname' créée avec succès!", 'success');
    } catch (PDOException $e) {
        console_log("Erreur lors de la création de la base de données: " . $e->getMessage(), 'error');
        exit(1);
    }
}

// Exécuter les migrations
function runMigrations() {
    $pdo = getConnection();
    $dbname = getenv('DB_NAME');
    $pdo->exec("USE `$dbname`");

    $migrationsDir = __DIR__ . '/../database/migrations';
    if (!is_dir($migrationsDir)) {
        console_log("Dossier de migrations non trouvé!", 'error');
        exit(1);
    }

    $migrations = glob($migrationsDir . '/*.sql');
    sort($migrations); // Trier les fichiers par nom

    foreach ($migrations as $migration) {
        $sql = file_get_contents($migration);
        console_log("\nExécution de la migration: " . basename($migration), 'info');
        
        try {
            $pdo->exec($sql);
            console_log("✓ Migration exécutée avec succès!", 'success');
        } catch (PDOException $e) {
            console_log("✗ Erreur lors de la migration: " . $e->getMessage(), 'error');
            exit(1);
        }
    }
}

// Afficher l'aide
function showHelp() {
    echo "\nUtilisation: php db-manager.php [command]\n";
    echo "\nCommandes disponibles:\n";
    echo "  create    Créer la base de données\n";
    echo "  migrate   Exécuter les migrations\n";
    echo "  fresh     Recréer la base de données et exécuter les migrations\n";
    echo "  help      Afficher cette aide\n\n";
}

// Traitement des commandes
loadEnv();

if ($argc < 2) {
    showHelp();
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'create':
        createDatabase();
        break;

    case 'migrate':
        runMigrations();
        break;

    case 'fresh':
        $pdo = getConnection();
        $dbname = getenv('DB_NAME');
        console_log("Suppression de la base de données existante...", 'warning');
        $pdo->exec("DROP DATABASE IF EXISTS `$dbname`");
        createDatabase();
        runMigrations();
        break;

    case 'help':
        showHelp();
        break;

    default:
        console_log("Commande inconnue: $command", 'error');
        showHelp();
        exit(1);
}
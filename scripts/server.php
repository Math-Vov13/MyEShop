<?php

if (php_sapi_name() !== 'cli') {
    die('Ce script doit être exécuté en ligne de commande');
}

// Configuration
$host = '127.0.0.1';  // ou '0.0.0.0' pour accepter les connexions externes
$port = 8000;
$docRoot = __DIR__ . '/../public';

// Fonction pour afficher des messages colorés
function console_log($message, $type = 'info') {
    $colors = [
        'error' => "\033[31m",   // Rouge
        'success' => "\033[32m", // Vert
        'info' => "\033[36m",    // Cyan
        'warning' => "\033[33m", // Jaune
        'reset' => "\033[0m"     // Reset
    ];

    echo $colors[$type] . $message . $colors['reset'] . PHP_EOL;
}

// Vérifier si le dossier public existe
if (!is_dir($docRoot)) {
    console_log("Erreur : Le dossier 'public' n'existe pas!", 'error');
    exit(1);
}

// Vérifier si le port est disponible
$socket = @fsockopen($host, $port, $errno, $errstr, 1);
if ($socket) {
    fclose($socket);
    console_log("Erreur : Le port $port est déjà utilisé!", 'error');
    exit(1);
}

// Afficher les informations de démarrage
console_log("\n=== Serveur de développement PHP ===\n", 'info');
console_log("📂 Document Root : $docRoot", 'info');
console_log("🌐 URL : http://$host:$port", 'info');
console_log("\nAppuyez sur Ctrl+C pour arrêter le serveur...\n", 'warning');

// Démarrer le serveur
$command = sprintf(
    'php -S %s:%d -t %s %s/router.php',
    $host,
    $port,
    escapeshellarg($docRoot),
    escapeshellarg($docRoot)
);

// Exécuter la commande
passthru($command);
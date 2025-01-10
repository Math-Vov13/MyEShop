<?php

// Fonction pour vérifier si le fichier demandé est un fichier statique
function isStaticFile($filename) {
    $staticExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'woff', 'woff2', 'ttf', 'eot'];
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    return in_array($extension, $staticExtensions);
}

// Récupérer l'URL demandée
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Si c'est un fichier statique et qu'il existe, le servir directement
if (isStaticFile($uri)) {
    $file = __DIR__ . $uri;
    if (file_exists($file)) {
        return false; // Laisser le serveur PHP gérer le fichier statique
    }
}

// Sinon, rediriger toutes les requêtes vers index.php
require_once __DIR__ . '/index.php';
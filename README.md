# MyEShop - Classic Shop

Ce projet est une boutique en ligne de jeux vidéo développée en PHP. Il utilise une architecture MVC simple et une base de données MySQL.</br>
Ce projet a été réalisé pour une l'évaluation finale du cours PHP MVC.

## ⚙ Prérequis

### Pour Linux
```bash
# Installation de PHP et ses extensions
sudo apt install php php-mysql

# Installation de MySQL
sudo apt install mysql-server

# Installation de Composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
sudo mv composer.phar /usr/local/bin/composer
```

### Pour Windows
1. Télécharger et installer [XAMPP](https://www.apachefriends.org/download.html) (inclut PHP et MySQL)
2. Télécharger et installer [Composer](https://getcomposer.org/download/)

## ⚡ Quick Start

toutes les instructions sont [ici](INSTRUCTIONS.md)

## 💻 Lancement du serveur

### Méthode 1 : Serveur de développement PHP
```bash
# Depuis le dossier du projet
php scripts/server.php
```
Le site sera accessible à l'adresse : http://localhost:8000

### Méthode 2 : Apache (XAMPP sous Windows)
1. Copier le projet dans le dossier `htdocs` de XAMPP
2. Accéder au site via : http://localhost/MyEShop_php/public

## Structure du projet
```
.
├── app/
│   ├── Config/         # Configuration (DB, etc.)
│   ├── Controllers/    # Contrôleurs
│   ├── Models/         # Modèles
│   └── Views/          # Vues
├── database/
│   └── migrations/     # Scripts SQL
├── public/
│   ├── assets/        # CSS, JS, images
│   ├── index.php      # Point d'entrée
│   └── router.php     # Routeur
├── scripts/           # Scripts utilitaires
├── vendor/           # Dépendances
├── .env              # Configuration environnement
└── composer.json     # Dépendances du projet
```

## Fonctionnalités
- 🏠 Page d'accueil
- 🎮 Catalogue de produits
- 🛒 Panier d'achat
- ⚫ Codes Promos
- 🟢 Vérification de la commande
- 💳 Système de paiement (à venir)
- 👤 Gestion des utilisateurs (à venir)

## Résolution des problèmes courants
problèmes que j'ai rencontrés lors de la réalisation de ce projet...

### Erreur de connexion à la base de données
1. Vérifier que MySQL est bien démarré
```bash
# Linux
sudo systemctl status mysql

# Windows
# Vérifier dans le panneau de contrôle XAMPP
```

2. Vérifier les informations de connexion dans `.env`
3. Tester la connexion
```bash
php scripts/test-db.php
```

### Erreur de permission
```bash
# Linux
sudo chown -R $USER:$USER .
chmod -R 755 .

# Windows
# Exécuter XAMPP en tant qu'administrateur
```

### Le serveur ne démarre pas
1. Vérifier qu'aucun autre service n'utilise le port 8000
```bash
# Linux
sudo lsof -i :8000

# Windows
netstat -ano | findstr :8000
```

2. Essayer un autre port en modifiant `scripts/server.php`


## Licence
Distribué sous la licence MIT. Voir `LICENSE` pour plus d'informations.

## Contact
Vovard - MathVov.91@outlook.fr
Lien du projet: https://github.com/Math-Vov13/MyEShop.git
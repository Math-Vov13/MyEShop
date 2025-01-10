# Instructions d'Installation et de Configuration

## Prérequis
- PHP 8.1 ou supérieur
- MySQL 8.0 ou supérieur
- Composer
- Serveur Web (Apache/Nginx)

## Installation

1. Cloner le repository :
```bash
git clone https://github.com/Math-Vov13/MyEShop.git
cd NewGame_pp
```

2. Installer les dépendances via Composer :
```bash
composer install
```

3. Configuration de l'environnement :
Copier le fichier `.env.example` vers `.env` et configurer les variables suivantes :

```env
# Configuration Base de données
DB_HOST=localhost
DB_NAME=myeshop_db
DB_USER=votre_utilisateur
DB_PASSWORD=votre_mot_de_passe

# Configuration Email
SMTP_HOST=
SMTP_PORT=
SMTP_USER=
SMTP_PASSWORD=

# Configuration Paiement
STRIPE_PUBLIC_KEY=
STRIPE_SECRET_KEY=

# Configuration Application
APP_URL=http://localhost
APP_ENV=development
APP_DEBUG=true
```

4. Instancier la base de données :
```bash
php scripts/init-db.php
```

5. Lancer le serveur :
```bash
php scripts/server.php
```

## Exemple de tests

- Acheter un produit
- Entrer des codes promo 'PHP', 'WELCOME', 'SUMMER2024' (l'un ne marchera pas car est périmé)
- Payer la commande
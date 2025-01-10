#!/bin/bash

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Vérifier si le script est exécuté en tant que root
if [ "$EUID" -ne 0 ]; then 
    echo -e "${RED}Ce script doit être exécuté en tant que root${NC}"
    exit 1
fi

# Définir le nom du site
SITE_NAME="myeshop"
# Obtenir le chemin absolu du projet
PROJECT_PATH=$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)
# Définir le document root
DOCUMENT_ROOT="$PROJECT_PATH/public"

# Créer la configuration Apache
CONFIG_FILE="/etc/apache2/sites-available/$SITE_NAME.conf"

echo -e "${YELLOW}Création de la configuration Apache...${NC}"

cat > "$CONFIG_FILE" << EOF
<VirtualHost *:80>
    ServerName $SITE_NAME.local
    ServerAlias www.$SITE_NAME.local
    DocumentRoot $DOCUMENT_ROOT

    <Directory $DOCUMENT_ROOT>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog \${APACHE_LOG_DIR}/$SITE_NAME-error.log
    CustomLog \${APACHE_LOG_DIR}/$SITE_NAME-access.log combined

    # Configuration PHP
    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>
</VirtualHost>
EOF

# Ajouter l'entrée dans /etc/hosts
echo -e "${YELLOW}Ajout de l'entrée dans /etc/hosts...${NC}"
echo "127.0.0.1 $SITE_NAME.local www.$SITE_NAME.local" >> /etc/hosts

# Activer le site
echo -e "${YELLOW}Activation du site...${NC}"
a2ensite $SITE_NAME.conf

# Activer les modules nécessaires
echo -e "${YELLOW}Activation des modules Apache nécessaires...${NC}"
a2enmod rewrite
a2enmod headers

# Vérifier la configuration
echo -e "${YELLOW}Vérification de la configuration Apache...${NC}"
apache2ctl configtest

# Redémarrer Apache si la configuration est valide
if [ $? -eq 0 ]; then
    echo -e "${YELLOW}Redémarrage d'Apache...${NC}"
    systemctl restart apache2
    echo -e "${GREEN}Configuration terminée !${NC}"
    echo -e "Vous pouvez maintenant accéder au site via : http://$SITE_NAME.local"
else
    echo -e "${RED}Erreur dans la configuration Apache${NC}"
    exit 1
fi
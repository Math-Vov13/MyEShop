-- Creation des tables principales



-- Table utilisateurs
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    firstname VARCHAR(100),
    lastname VARCHAR(100),
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);



-- Table catégories
CREATE TABLE IF NOT EXISTS categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- exemples de catégories (pour les tests)
INSERT INTO categories (name, slug, description) VALUES
('Jeux d''action', 'jeux-action', 'Des jeux pleins d''action et d''aventure'),
('RPG', 'rpg', 'Des jeux de rôle passionnants'),
('Stratégie', 'strategie', 'Des jeux qui font réfléchir');



-- Table produits
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    category_id INT,
    image_url VARCHAR(255),
    platform VARCHAR(100),
    genre VARCHAR(100),
    publisher VARCHAR(100),
    release_date DATE,
    rating DECIMAL(3,1) DEFAULT 0.0,
    review_count INT DEFAULT 0,
    discount INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- exemples de produits (pour les tests)
INSERT INTO products (
    name, slug, description, price, stock, 
    category_id, image_url, platform, genre, 
    publisher, release_date, rating, review_count, discount
) VALUES
    (
        'The Last Adventure', 
        'the-last-adventure', 
        'Un jeu d''aventure épique rempli d''action et de mystère.', 
        49.99, 100, 1, '/assets/images/game1.jpg',
        'PC, PS5, Xbox Series X', 'Action/Aventure',
        'GameStudio', '2023-01-15', 4.5, 128, 0
    ),
    (
        'Medieval Quest', 
        'medieval-quest', 
        'Un RPG médiéval fantastique avec un monde ouvert immersif.', 
        39.99, 50, 2, '/assets/images/game2.jpg',
        'PC, PS5', 'RPG',
        'RPG Masters', '2023-03-20', 4.8, 256, 15
    ),
    (
        'Space Commander', 
        'space-commander', 
        'Un jeu de stratégie spatial avec des batailles épiques.', 
        29.99, 75, 3, '/assets/images/game3.jpg',
        'PC', 'Stratégie',
        'Strategy Games Inc', '2023-02-10', 4.2, 96, 0
    ),
    (
        'Action Heroes',
        'action-heroes',
        'Un jeu d''action avec des héros légendaires.',
        59.99, 80, 1, '/assets/images/game4.jpg',
        'PC, PS5', 'Action',
        'Action Games Ltd', '2023-04-05', 4.7, 150, 10
    ),
    (
        'Fantasy Realms',
        'fantasy-realms',
        'Un RPG fantastique avec des créatures mythiques.',
        44.99, 60, 2, '/assets/images/game5.jpg',
        'PC, Xbox Series X', 'RPG',
        'Fantasy Studios', '2023-05-12', 4.6, 200, 5
    ),
    (
        'War Strategy',
        'war-strategy',
        'Un jeu de stratégie militaire avec des batailles réalistes.',
        34.99, 90, 3, '/assets/images/game6.jpg',
        'PC', 'Stratégie',
        'War Games Inc', '2023-06-25', 4.3, 100, 0
    ),
    (
        'Adventure Quest',
        'adventure-quest',
        'Un jeu d''aventure avec des quêtes épiques.',
        49.99, 100, 1, '/assets/images/game7.jpg',
        'PC, PS5, Xbox Series X', 'Action/Aventure',
        'Adventure Games', '2023-07-10', 4.5, 120, 0
    ),
    (
        'Dragon Saga',
        'dragon-saga',
        'Un RPG avec des dragons et des batailles épiques.',
        39.99, 50, 2, '/assets/images/game8.jpg',
        'PC, PS5', 'RPG',
        'Dragon Studios', '2023-08-15', 4.8, 250, 15
    ),
    (
        'Galactic Conquest',
        'galactic-conquest',
        'Un jeu de stratégie spatial avec des batailles interstellaires.',
        29.99, 75, 3, '/assets/images/game9.jpg',
        'PC', 'Stratégie',
        'Galactic Games', '2023-09-20', 4.2, 90, 0
    ),
    (
        'Ninja Warrior',
        'ninja-warrior',
        'Un jeu d''action avec des ninjas et des combats intenses.',
        59.99, 80, 1, '/assets/images/game10.jpg',
        'PC, PS5', 'Action',
        'Ninja Games', '2023-10-05', 4.7, 150, 10
    ),
    (
        'Mystic Realms',
        'mystic-realms',
        'Un RPG avec des mondes mystiques et des créatures magiques.',
        44.99, 60, 2, '/assets/images/game11.jpg',
        'PC, Xbox Series X', 'RPG',
        'Mystic Studios', '2023-11-12', 4.6, 200, 5
    ),
    (
        'Empire Builder',
        'empire-builder',
        'Un jeu de stratégie avec des empires à construire et à défendre.',
        34.99, 90, 3, '/assets/images/game12.jpg',
        'PC', 'Stratégie',
        'Empire Games', '2023-12-25', 4.3, 100, 0
    ),
    (
        'Epic Adventure',
        'epic-adventure',
        'Un jeu d''aventure avec des quêtes épiques et des mystères à résoudre.',
        49.99, 100, 1, '/assets/images/game13.jpg',
        'PC, PS5, Xbox Series X', 'Action/Aventure',
        'Epic Games', '2024-01-10', 4.5, 120, 0
    ),
    (
        'Fantasy Chronicles',
        'fantasy-chronicles',
        'Un RPG avec des chroniques fantastiques et des héros légendaires.',
        39.99, 50, 2, '/assets/images/game14.jpg',
        'PC, PS5', 'RPG',
        'Fantasy Chronicles Studios', '2024-02-15', 4.8, 250, 15
    ),
    (
        'Star Conquest',
        'star-conquest',
        'Un jeu de stratégie spatial avec des batailles interstellaires.',
        29.99, 75, 3, '/assets/images/game15.jpg',
        'PC', 'Stratégie',
        'Star Games', '2024-03-20', 4.2, 90, 0
    ),
    (
        'Samurai Showdown',
        'samurai-showdown',
        'Un jeu d''action avec des samouraïs et des combats intenses.',
        59.99, 80, 1, '/assets/images/game16.jpg',
        'PC, PS5', 'Action',
        'Samurai Games', '2024-04-05', 4.7, 150, 10
    ),
    (
        'Enchanted Realms',
        'enchanted-realms',
        'Un RPG avec des mondes enchantés et des créatures magiques.',
        44.99, 60, 2, '/assets/images/game17.jpg',
        'PC, Xbox Series X', 'RPG',
        'Enchanted Studios', '2024-05-12', 4.6, 200, 5
    ),
    (
        'Kingdom Builder',
        'kingdom-builder',
        'Un jeu de stratégie avec des royaumes à construire et à défendre.',
        34.99, 90, 3, '/assets/images/game18.jpg',
        'PC', 'Stratégie',
        'Kingdom Games', '2024-06-25', 4.3, 100, 0
    ),
    (
        'Legendary Quest',
        'legendary-quest',
        'Un jeu d''aventure avec des quêtes légendaires et des mystères à résoudre.',
        49.99, 100, 1, '/assets/images/game19.jpg',
        'PC, PS5, Xbox Series X', 'Action/Aventure',
        'Legendary Games', '2024-07-10', 4.5, 120, 0
    );
CREATE TABLE IF NOT EXISTS promo_codes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(50) NOT NULL UNIQUE,
    discount_percent INT NOT NULL,
    active BOOLEAN DEFAULT true,
    start_date DATETIME,
    end_date DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- exemples de promo codes (pour les tests)
INSERT INTO promo_codes (code, discount_percent, active, start_date, end_date) VALUES
('PHP', 30, true, '2025-01-01 00:00:00', '2025-12-31 23:59:59'),
('WELCOME', 10, true, '2025-01-01 00:00:00', '2025-12-31 23:59:59'),
('SUMMER2024', 20, true, '2024-06-01 00:00:00', '2024-08-31 23:59:59');



CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) DEFAULT NULL, 
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` ENUM('user', 'admin', 'super_admin') DEFAULT 'user',  
  
  `adresse` varchar(255) DEFAULT NULL,
  `ville` varchar(100) DEFAULT NULL,
  `code_postal` varchar(10) DEFAULT NULL,
  
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` TEXT,          
  `image` VARCHAR(255),        
  
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL CHECK (prix >= 0),
  `image` longtext DEFAULT NULL, 
  `category_id` int(11) DEFAULT NULL,
  
  `stock` int(11) NOT NULL DEFAULT 0 CHECK (stock >= 0),
  `actif` boolean DEFAULT TRUE, 
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



CREATE TABLE `carts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantite` int(11) DEFAULT 1 CHECK (quantite > 0),
  
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  
  `numero_commande` varchar(50) NOT NULL, 
  `statut` enum('en_attente','payee','expediee','livree','annulee') DEFAULT 'en_attente',
  `total` decimal(10,2) NOT NULL,
  
  `adresse_livraison` varchar(255) NOT NULL,
  `ville_livraison` varchar(100) NOT NULL,
  `code_postal_livraison` varchar(10) NOT NULL,
  
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_numero` (`numero_commande`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `order_lines` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  
  `quantite` int(11) NOT NULL CHECK (quantite > 0),
  `prix_unitaire` decimal(10,2) NOT NULL, 
  `sous_total` decimal(10,2) NOT NULL,
  
  PRIMARY KEY (`id`),
  KEY `idx_order_lines_order` (`order_id`),
  KEY `idx_order_lines_product` (`product_id`),
  CONSTRAINT `fk_order_lines_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_order_lines_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

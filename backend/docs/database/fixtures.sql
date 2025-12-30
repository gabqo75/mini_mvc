
INSERT INTO administrators (nom_utilisateur, email, mot_de_passe, role) VALUES
('super_alice', 'alice@admin.com', 'mdp_hash_alice', 'super_admin'),
('gest_bob', 'bob@admin.com', 'mdp_hash_bob', 'gestionnaire');

INSERT INTO categories (nom, description) VALUES
('Burger Classique', 'Les incontournables de la maison.'), 
('Burger Végétarien', 'Options sans viande.'),            
('Accompagnement', 'Frites, Salades et plus.'),           
('Boisson', 'Soda, jus et eau.'),                        
('Dessert', 'Petites douceurs sucrées.');                

INSERT INTO products (nom, description_detaillee, prix, stock, id_categorie) VALUES
('Big Mac', 'Le classique double étage.', 6.50, 100, 1),
('Cheeseburger', 'Simple et efficace.', 2.00, 200, 1),
('Royal Cheese', 'Bœuf, cheddar, cornichons, oignons.', 4.80, 80, 1),
('Royal Bacon', 'Bœuf, bacon grillé, sauce.', 5.10, 90, 1),
('McChicken', 'Poulet pané et sauce.', 4.50, 120, 1),
('Double Cheese', 'Deux fois plus de fromage!', 3.50, 150, 1),
('Filet-O-Fish', 'Poisson pané et sauce tartare.', 4.20, 75, 1);

INSERT INTO products (nom, description_detaillee, prix, stock, id_categorie) VALUES
('Veggie Burger', 'Galette végétale.', 5.50, 50, 2),
('Salade César Végé', 'Salade sans poulet.', 7.00, 60, 2),
('Wrap Végétarien', 'Tortilla avec légumes frais.', 4.00, 85, 2);

INSERT INTO products (nom, description_detaillee, prix, stock, id_categorie) VALUES
('Frites Petite', 'Portion classique.', 2.50, 300, 3),
('Frites Moyenne', 'Portion généreuse.', 3.00, 250, 3),
('Frites Grande', 'Pour les gourmands.', 3.50, 200, 3),
('Potatoes', 'Pommes de terre épicées.', 3.80, 150, 3),
('McSalad', 'Salade verte et tomates.', 3.20, 180, 3),
('Nuggets (6)', '6 morceaux de poulet.', 4.90, 110, 3);

INSERT INTO products (nom, description_detaillee, prix, stock, id_categorie) VALUES
('Coca-Cola (M)', 'Moyen format.', 2.80, 400, 4),
('Fanta (M)', 'Moyen format.', 2.80, 350, 4),
('Eau Minérale', 'Bouteille 50cl.', 2.00, 500, 4),
('Jus d''Orange', 'Pur jus pressé.', 3.20, 200, 4),
('Café', 'Expresso simple.', 1.50, 600, 4);

INSERT INTO produit (nom, description_detaillee, prix, stock, id_categorie) VALUES
('McFlurry', 'Glace et topping au choix.', 4.00, 100, 5),
('Sundae Chocolat', 'Glace vanille et sauce chocolat.', 3.50, 100, 5),
('Apple Pie', 'Tarte aux pommes chaude.', 2.50, 90, 5),
('Cookie', 'Cookie aux pépites de chocolat.', 1.80, 150, 5);


INSERT INTO client (nom, prenom, email, mot_de_passe, adresse, ville, code_postal) VALUES
('Dupont', 'Jean', 'jean.dupont@mail.com', 'mdp_jean', '10 Rue de Paris', 'Paris', 75001), 
('Martin', 'Sophie', 'sophie.martin@mail.com', 'mdp_sophie', '22 Avenue de Lyon', 'Lyon', 69002),  
('Petit', 'Marc', 'marc.petit@mail.com', 'mdp_marc', '5 Boulevard de la Gare', 'Marseille', 13005), 
('Durand', 'Marie', 'marie.durand@mail.com', 'mdp_marie', '8 Rue des Fleurs', 'Lille', 59000),  
('Leroy', 'Pierre', 'pierre.leroy@mail.com', 'mdp_pierre', '1 Place Centrale', 'Bordeaux', 33000); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0001', 'livree', 12.30, '10 Rue de Paris', 'Paris', 75001, 1); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0002', 'en_cours', 19.30, '22 Avenue de Lyon', 'Lyon', 69002, 2); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0003', 'en_attente', 3.50, '5 Boulevard de la Gare', 'Marseille', 13005, 3); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0004', 'livree', 19.10, '8 Rue des Fleurs', 'Lille', 59000, 4); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0005', 'livree', 12.30, '10 Rue de Paris', 'Paris', 75001, 1);

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0006', 'annulee', 11.80, '1 Place Centrale', 'Bordeaux', 33000, 5); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0007', 'en_cours', 10.30, '22 Avenue de Lyon', 'Lyon', 69002, 2); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0008', 'en_attente', 14.50, '5 Boulevard de la Gare', 'Marseille', 13005, 3); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0009', 'livree', 17.70, '8 Rue des Fleurs', 'Lille', 59000, 4); 

INSERT INTO orders (numero, statut, montant_total, adresse_livraison, ville_livraison, code_postal_livraison, id_client) VALUES
('CMD0010', 'livree', 9.40, '1 Place Centrale', 'Bordeaux', 33000, 5); 

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(1, 1, 1, 6.50, 6.50),
(1, 6, 1, 3.00, 3.00),
(1, 13, 1, 2.80, 2.80);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(2, 8, 1, 5.50, 5.50),
(2, 12, 2, 4.90, 9.80),
(2, 17, 1, 4.00, 4.00);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(3, 2, 1, 2.00, 2.00),
(3, 16, 1, 1.50, 1.50);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(4, 1, 1, 6.50, 6.50),
(4, 4, 1, 5.10, 5.10),
(4, 7, 1, 3.50, 3.50),
(4, 17, 1, 4.00, 4.00);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(5, 5, 2, 3.50, 7.00),
(5, 5, 1, 2.50, 2.50),
(5, 13, 1, 2.80, 2.80);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(6, 3, 1, 4.80, 4.80),
(6, 8, 1, 3.80, 3.80),
(6, 15, 1, 3.20, 3.20);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(7, 5, 1, 4.50, 4.50),
(7, 6, 1, 3.00, 3.00),
(7, 13, 1, 2.80, 2.80);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(8, 9, 1, 7.00, 7.00),
(8, 7, 1, 3.50, 3.50),
(8, 17, 1, 4.00, 4.00);

$INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(9, 7, 1, 4.20, 4.20),
(9, 7, 3, 3.50, 10.50),
(9, 14, 2, 2.00, 4.00);

INSERT INTO ligne_de_commande (id_commande, id_produit, quantite, prix_unitaire, sous_total) VALUES
(10, 4, 1, 5.10, 5.10),
(10, 19, 1, 2.50, 2.50),
(10, 20, 1, 1.80, 1.80);
<?php
$config = parse_ini_file('../app/config.ini');
try {
    $pdo = new PDO("mysql:host=" . $config['DB_HOST'] . ";dbname=" . $config['DB_NAME'], $config['DB_USERNAME'], $config['DB_PASSWORD']);
    echo "Connexion à la base de données réussie !";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
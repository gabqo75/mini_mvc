<?php
namespace Mini\Models;
use Mini\Core\Database;
use PDO;

class Product {
    public static function getAll() {
        $pdo = Database::getPDO();
        $stmt = $pdo->query("SELECT p.*, c.nom as category_name 
                             FROM products p 
                             LEFT JOIN categories c ON p.category_id = c.id
                             WHERE p.actif = 1");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
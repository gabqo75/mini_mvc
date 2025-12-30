<?php
namespace Mini\Models;
use Mini\Core\Database;
use PDO;

class Cart
{
    public static function getByUser($userId) {
        $pdo = Database::getPDO();
        $sql = "SELECT c.id as cart_id, c.quantite, c.product_id, p.nom, p.prix, p.image 
                FROM carts c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function add($userId, $productId, $qty) {
        $pdo = Database::getPDO();
        
        $check = $pdo->prepare("SELECT quantite FROM carts WHERE user_id = ? AND product_id = ?");
        $check->execute([$userId, $productId]);
        $existing = $check->fetch();

        if ($existing) {
            $stmt = $pdo->prepare("UPDATE carts SET quantite = quantite + ? WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$qty, $userId, $productId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO carts (user_id, product_id, quantite) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $qty]);
        }
    }


    public static function remove($cartId)
    {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("DELETE FROM carts WHERE id = ?");
        return $stmt->execute([$cartId]);
    }
}
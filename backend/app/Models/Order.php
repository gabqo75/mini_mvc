<?php
namespace Mini\Models;
use Mini\Core\Database;
use PDO;

class Order {
    

    public static function createFromCart($userId) {
        $pdo = Database::getPDO();
        
        $cartItems = Cart::getByUser($userId);
        if (empty($cartItems)) return false;

        $user = User::findById($userId);
        if (!$user) return false;

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['prix'] * $item['quantite'];
        }

        try {
            $pdo->beginTransaction();

            $numCommande = 'CMD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -5));


            $sqlOrder = "INSERT INTO orders 
                (user_id, numero_commande, total, statut, adresse_livraison, ville_livraison, code_postal_livraison, created_at) 
                VALUES (?, ?, ?, 'payee', ?, ?, ?, NOW())";
            
            $stmt = $pdo->prepare($sqlOrder);
            $stmt->execute([
                $userId, 
                $numCommande, 
                $total, 
                $user['adresse'] ?? 'Non renseignée',
                $user['ville'] ?? 'Inconnue',
                $user['code_postal'] ?? '00000'
            ]);
            
            $orderId = $pdo->lastInsertId();


            $sqlLine = "INSERT INTO order_lines (order_id, product_id, quantite, prix_unitaire, sous_total) VALUES (?, ?, ?, ?, ?)";
            $stmtLine = $pdo->prepare($sqlLine);

            foreach ($cartItems as $item) {
                $sousTotal = $item['prix'] * $item['quantite'];
                $stmtLine->execute([
                    $orderId,
                    $item['product_id'],
                    $item['quantite'],
                    $item['prix'], 
                    $sousTotal
                ]);
            }

            $stmtClean = $pdo->prepare("DELETE FROM carts WHERE user_id = ?");
            $stmtClean->execute([$userId]);

            $pdo->commit();
            return true;

        } catch (\Exception $e) {
            $pdo->rollBack();

            return false;
        }
    }
    
    public static function getHistory($userId) {
        $pdo = Database::getPDO();
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
<?php
namespace Mini\Controllers;

use Mini\Models\Cart;

class CartController {
    
    public function getCart() {
        $userId = $_GET['user_id'] ?? 0;
        header('Content-Type: application/json');
        echo json_encode(Cart::getByUser($userId));
        exit;
    }

    public function add() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['user_id']) || empty($data['product_id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Données manquantes']);
            exit;
        }

        $quantite = $data['quantite'] ?? 1;

        $success = Cart::add($data['user_id'], $data['product_id'], $quantite);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => $success]);
        exit;
    }

    public function remove()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!empty($data['cart_id'])) {
            
            $success = Cart::remove($data['cart_id']);
            
            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'ID de panier manquant (cart_id)']);
        }
        exit;
    }
}
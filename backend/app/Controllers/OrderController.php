<?php
namespace Mini\Controllers;

use Mini\Models\Order; 

class OrderController {
    
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (empty($data['user_id'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Utilisateur non connecté']);
            exit;
        }

        $success = Order::createFromCart($data['user_id']);

        if ($success) {
            echo json_encode(['success' => true, 'message' => 'Commande validée !']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la commande (Panier vide ou stock insuffisant)']);
        }
        exit;
    }

    public function listByUser() {
        $userId = $_GET['user_id'] ?? 0;
        
        $orders = Order::getHistory($userId);
        
        header('Content-Type: application/json');
        echo json_encode($orders);
        exit;
    }
}
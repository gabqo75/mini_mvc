<?php
namespace Mini\Controllers;

use Mini\Models\User;

class AuthController {
    
    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $user = User::findByEmail($data['email']);
        
        if ($user && password_verify($data['password'], $user['password'])) {
            unset($user['password']);
            
            echo json_encode([
                'success' => true, 
                'user' => $user
            ]);
        } else {
            http_response_code(401);
            echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect']);
        }
        exit;
    }

    public function register() {
        $data = json_decode(file_get_contents('php://input'), true);

        // Vérification des champs requis
        if (empty($data['nom']) || empty($data['email']) || empty($data['password']) || empty($data['adresse'])) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
            exit;
        }

        if (User::findByEmail($data['email'])) {
            http_response_code(409);
            echo json_encode(['success' => false, 'message' => 'Cet email est déjà utilisé']);
            exit;
        }

        $user = new User();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom'] ?? '');
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setAdresse($data['adresse']);
        $user->setVille($data['ville']);
        $user->setCodePostal($data['code_postal']);

        if ($user->save()) {
            echo json_encode(['success' => true, 'message' => 'Compte créé avec succès ! Connectez-vous.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'inscription']);
        }
        exit;
    }
}
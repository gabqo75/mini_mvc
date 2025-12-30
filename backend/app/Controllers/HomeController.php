<?php

declare(strict_types=1);

namespace Mini\Controllers;

use Mini\Core\Controller;
use Mini\Models\User;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'Mini MVC',
            'prenom' => 'Toto',
            'prenom2' => 'Tata',
        ]);
    }

    public function users(): void
    {
        $users = User::getAll();
        if (ob_get_length()) ob_clean();
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($users, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public function save(): void
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if ($data && isset($data['nom'], $data['email'])) {
            $user = new User();
            $user->setNom($data['nom']); //
            $user->setEmail($data['email']); //
            
            $success = $user->save(); //

            header('Content-Type: application/json');
            echo json_encode(['success' => $success]);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Données invalides']);
        }
        exit;
    }
}
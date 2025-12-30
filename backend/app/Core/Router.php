<?php

namespace Mini\Core;

class Router
{
    private $routes;

    public function __construct($routes)
    {
        $this->routes = $routes;
    }

    public function dispatch($method, $uri)
    {
        // 1. GESTION CORS (Indispensable pour React)
        // Autorise l'accès depuis n'importe quelle origine
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

        // Si la requête est une pré-vérification (OPTIONS), on arrête là avec un succès
        if ($method == 'OPTIONS') {
            http_response_code(200);
            exit;
        }

        // 2. NETTOYAGE DE L'URL (Compatible XAMPP / Production)
        // On récupère le chemin sans les paramètres GET (?id=...)
        $requestPath = parse_url($uri, PHP_URL_PATH);
        
        // On récupère le dossier racine du script (ex: /mini_mvc/backend/public)
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        
        // On retire le dossier racine de l'URL demandée pour avoir le chemin "propre"
        // Ex: "/mini_mvc/backend/public/products" devient "/products"
        if (strpos($requestPath, $scriptName) === 0) {
            $path = substr($requestPath, strlen($scriptName));
        } else {
            $path = $requestPath;
        }

        // Si le chemin est vide, c'est la racine
        if (empty($path) || $path === '') {
            $path = '/';
        }

        // 3. RECHERCHE DE LA ROUTE
        foreach ($this->routes as $route) {
            // On décompose la route définie
            list($routeMethod, $routePath, $handler) = $route;
            
            // On vérifie si la méthode et le chemin correspondent
            if ($method === $routeMethod && $path === $routePath) {
                list($class, $action) = $handler;
                
                if (class_exists($class)) {
                    $controller = new $class();
                    
                    if (method_exists($controller, $action)) {
                        $controller->$action();
                        return;
                    } else {
                        $this->sendError(500, "Methode $action introuvable dans $class");
                    }
                } else {
                    $this->sendError(500, "Classe $class introuvable");
                }
                return;
            }
        }

        // 4. SI AUCUNE ROUTE N'EST TROUVÉE
        $this->sendError(404, "Route non trouvee : $path (Methode: $method)");
    }

    // Petite fonction utilitaire pour renvoyer les erreurs proprement en JSON
    private function sendError($code, $message) {
        http_response_code($code);
        echo json_encode(["success" => false, "error" => $message]);
        exit;
    }
}
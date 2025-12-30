<?php

// Active le mode strict
declare(strict_types=1);

namespace Mini\Core;

class Controller
{
    /**
     * Méthode utilitaire pour rendre une vue avec des paramètres
     */
    protected function render($view, $params = [])
    {
        // Correction : On retire "array:" qui bloquait PHP
        extract($params);

        // Chemins des fichiers
        $viewFile = dirname(__DIR__) . '/Views/' . $view . '.php';
        $layoutFile = dirname(__DIR__) . '/Views/layout.php';

        // Vérification que les fichiers existent avant de les inclure
        if (!file_exists($viewFile)) {
            die("Erreur : La vue spécifiée est introuvable ($viewFile)");
        }

        // Démarre la capture de sortie
        ob_start();
        
        // Inclut la vue spécifique (utilise les variables extraites de $params)
        require $viewFile;
        
        // Stocke le contenu de la vue dans $content pour le layout.php
        $content = ob_get_clean();

        // Vérifie et inclut le layout principal
        if (file_exists($layoutFile)) {
            require $layoutFile;
        } else {
            // Si pas de layout, on affiche juste le contenu
            echo $content;
        }
    }
}
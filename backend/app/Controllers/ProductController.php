<?php

namespace Mini\Controllers;


use Mini\Models\Product;

class ProductController
{

    public function listProducts()
    {
        $products = Product::getAll();
        
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($products, JSON_UNESCAPED_UNICODE);
        exit;
    }


    public function show()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $product = Product::findById($id);

        header('Content-Type: application/json; charset=utf-8');

        if ($product) {
            echo json_encode($product, JSON_UNESCAPED_UNICODE);
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Produit introuvable"]);
        }
        exit;
    }
}
<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use Mini\Core\Router;
use Mini\Controllers\HomeController;
use Mini\Controllers\AuthController;
use Mini\Controllers\ProductController;
use Mini\Controllers\CartController;
use Mini\Controllers\OrderController;


$routes = [
    ['GET',  '/',             [HomeController::class, 'index']],
    
    ['POST', '/register',     [AuthController::class, 'register']],
    ['POST', '/login',        [AuthController::class, 'login']],
    
    ['GET',  '/products',     [ProductController::class, 'listProducts']], 
    ['GET',  '/product',      [ProductController::class, 'show']],
    
    ['GET',  '/cart',         [CartController::class, 'getCart']],
    ['POST', '/cart/add',     [CartController::class, 'add']],
    ['POST', '/cart/remove',  [CartController::class, 'remove']],
    
    ['POST', '/order/create', [OrderController::class, 'create']],
    ['GET',  '/orders',       [OrderController::class, 'listByUser']], 
];

$router = new Router($routes);


$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
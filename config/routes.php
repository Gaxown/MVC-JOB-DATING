<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Core\Router;

$r = new Router();
$r->get('/login', [AuthController::class, 'showLogin']);
$r->post('/login', [AuthController::class, 'login']);
$r->get('/logout', [AuthController::class, 'logout']);
$r->get('/register', [AuthController::class, 'showRegister']);
$r->post('/register', [AuthController::class, 'register']);

$r->get('/', [HomeController::class, 'index']);
$r->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

//company routes


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


//Annoucements
use App\Controllers\AnnouncementsController;

$r->get('/announcements', [AnnouncementsController::class, 'index']);
$r->get('/announcements/create', [AnnouncementsController::class, 'createForm']);
$r->post('/announcements/create', [AnnouncementsController::class, 'store']);
$r->get('/announcements/details/{id}', [AnnouncementsController::class, 'show']);
$r->get('/announcements/edit/{id}', [AnnouncementsController::class, 'editForm']);
$r->post('/announcements/edit/{id}', [AnnouncementsController::class, 'update']);
$r->get('/announcements/delete/{id}', [AnnouncementsController::class, 'deleteAnnouncement']);




$r->get('/', [HomeController::class, 'index']);
$r->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

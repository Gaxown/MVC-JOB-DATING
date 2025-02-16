<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\CompaniesController;
use App\Core\Router;

$r = new Router();
$r->get('/login', [AuthController::class, 'showLogin']);
$r->post('/login', [AuthController::class, 'login']);
$r->get('/logout', [AuthController::class, 'logout']);
$r->get('/register', [AuthController::class, 'showRegister']);
$r->post('/register', [AuthController::class, 'register']);


//Annoucements
use App\Controllers\AnnouncementsController;

$r->get('/admin/announcements', [AnnouncementsController::class, 'index']);
$r->get('/admin/announcements/create', [AnnouncementsController::class, 'createForm']);
$r->post('/admin/announcements/store', [AnnouncementsController::class, 'store']);
$r->post('/search-announcements', [AnnouncementsController::class, 'search']);
$r->get('/admin/announcements/details/{id}', [AnnouncementsController::class, 'show']);
$r->get('/admin/announcements/update/{id}', [AnnouncementsController::class, 'editForm']);
$r->post('/admin/announcements/update/{id}', [AnnouncementsController::class, 'update']);
$r->get('/admin/announcements/delete/{id}', [AnnouncementsController::class, 'softDeleteAnnouncement']);

// soft delete

$r->get('/admin/removedOffers', [AnnouncementsController::class, 'removed']);
$r->post('/admin/announcements/softdelete/{id}', [AnnouncementsController::class, 'softDeleteAnnouncement']);
$r->post('/admin/announcements/restore/{id}', [AnnouncementsController::class, 'restoreAnnouncement']);


//Companies router
$r->get('/admin/companies', [CompaniesController::class, 'index']);
$r->get('/admin/companies/create', [CompaniesController::class, 'createForm']);
$r->post('/admin/companies/store', [CompaniesController::class, 'store']);
$r->get('/admin/companies/update/{id}', [CompaniesController::class, 'updateForm']);
$r->post('/admin/companies/update/{id}', [CompaniesController::class, 'update']);
$r->post('/admin/companies/delete/{id}', [CompaniesController::class, 'delete']);



$r->get('/', [HomeController::class, 'index']);
$r->get('/admin/dashbord', [HomeController::class, 'dashboard']);
$r->get('/admin/users', [HomeController::class, 'users']);



$r->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

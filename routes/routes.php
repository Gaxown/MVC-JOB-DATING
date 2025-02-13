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

$r->get('/announcements', [AnnouncementsController::class, 'index']);
$r->get('/announcements/create', [AnnouncementsController::class, 'createForm']);
$r->post('/announcements/create', [AnnouncementsController::class, 'store']);
$r->get('/announcements/edit/{id}', [AnnouncementsController::class, 'editForm']);
$r->post('/announcements/edit/{id}', [AnnouncementsController::class, 'update']);
$r->get('/announcements/delete/{id}', [AnnouncementsController::class, 'deleteAnnouncement']);

//Companies router
$r->get('/admin/companies', [CompaniesController::class, 'index']);
$r->post('/admin/addCompany', [CompaniesController::class, 'createCompany']);
$r->get('/admin/addCompany', [CompaniesController::class, 'showFormCreateCompany']);
$r->get('/admin/company/update/{id}', [CompaniesController::class, 'showFormUpdateCompany']);
// $r->post('/admin/companies/edit/{company.id}', [CompaniesController::class, 'updateCompany']);
$r->post('/admin/companies/delete/{id}', [CompaniesController::class, 'deleteCompany']);


$r->get('/', [HomeController::class, 'index']);
$r->get('/admin/dashbord', [HomeController::class, 'dashboardAdmin']);
$r->get('/admin/users', [HomeController::class, 'pageUsers']);
$r->get('/admin/offers', [HomeController::class, 'pageOffers']);


$r->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Core\View;

class HomeController extends Controller
{
    public function __construct()
    {
        Middleware::handle();
    }

    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            header('Location: /login');
            exit();
        }

        switch ($user->role->name) {
            case 'admin':
                return View::render('admin/dashbord', ['user' => $user]);
            case 'user':
                return View::render('home/home', ['user' => $user]);
            default:
                return View::render('home/home', ['user' => $user]);
        }
    }
}

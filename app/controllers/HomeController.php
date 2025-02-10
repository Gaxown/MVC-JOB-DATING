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
                return View::render('home/admin', ['user' => $user]);
            case 'teacher':
                return View::render('home/teacher', ['user' => $user]);
            default:
                return View::render('home/user', ['user' => $user]);
        }
    }
}

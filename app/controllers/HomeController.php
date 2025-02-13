<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Core\View;
use App\Models\Announcement;

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

        $announcements = Announcement::getAllAnnouncements();

        switch ($user->role->name) {
            case 'admin':
                return View::render('admin/dashbord', ['user' => $user, 'announcements' => $announcements]);
            case 'user':
                return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);
            default:
                return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);
        }
        return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);

    }

    public function dashboardAdmin(){
        return View::render('admin/dashbord');
    }
    public function pageUsers(){
        return View::render('admin/users');
    }
    public function pageOffers(){
        return View::render('admin/offers');
    }
}
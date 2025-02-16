<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Core\View;
use App\Models\Announcement;
use App\Models\User;
use App\Models\Company;

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
                $totalUsers = User::count();
                $totalCompanies = Company::count();
                $totalOffers = Announcement::count();
        
                return View::render('admin/dashbord', [
                    'totalUsers' => $totalUsers,
                    'totalCompanies' => $totalCompanies,
                    'totalOffers' => $totalOffers
                ]);
            case 'user':
                return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);
            default:
                return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);
        }
        return View::render('home/home', ['user' => $user, 'announcements' => $announcements]);
    }

    public function dashboard()
    {   
        $totalUsers = User::count();
        $totalCompanies = Company::count();
        $totalOffers = Announcement::count();

        return View::render('admin/dashbord', [
            'totalUsers' => $totalUsers,
            'totalCompanies' => $totalCompanies,
            'totalOffers' => $totalOffers
        ]);
        // return View::render('admin/dashbord');
    }
    public function users()
    {   
        $users = User::all();
        return View::render('admin/users', compact('users'));
    }
    public function announcements()
    {
        return View::render('admin/announcements');
    }
}

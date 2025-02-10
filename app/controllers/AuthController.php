<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Core\Middleware;
use App\Core\Security;
use App\Core\Session;
use App\Core\View;
use App\Models\User;

class AuthController extends Controller
{

    public function showLogin()
    {
        Middleware::handleGuest();
        return View::render('auth/login');
    }

    public function login()
    {
        Middleware::handleGuest();
        $cleanedData = Security::clean($_POST);
        $email = $cleanedData['email'];
        $password = $cleanedData['password'];

        if (Auth::attempt($email, $password)) {
            header('Location: /');
            exit();
        }

        Session::set('login_error', 'Invalid email or password.');
        header('Location: /login');
        exit();
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /login');
        exit();
    }

    public function showRegister()
    {
        Middleware::handleGuest();
        return View::render('auth/register');
    }

    public function register()
    {
        Middleware::handleGuest();
        $cleanedData = Security::clean($_POST);
        $user = new User();
        $user->name = $cleanedData['name'];
        $user->email = $cleanedData['email'];
        $user->password = Security::hashPassword($cleanedData['password']);
        $user->role_id = 2;
        $user->save();

        Auth::login($user);
        if (Auth::user()->role->name == 'admin') {
        }
        header('Location: /');
        exit();
    }
}

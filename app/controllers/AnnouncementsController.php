<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Auth;
use App\Core\Validator;
use App\Models\Announcement;
use App\Models\Company;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return View::render('admin/announcements', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = Announcement::find($id);
        return View::render('home/details', compact('announcement'));
    }

    public function createForm()
    {
        $companies = Company::all();
        return View::render('admin/announcements/create', compact('companies'));
    }

    public function store()
    {
        Announcement::create([
            'title' => $_POST['title'],

            'company_id' => Validator::validate('company_id', 'required|numeric'),
            'candidates_count' => Validator::validate('candidates_count', 'required|numeric'),
            'cover' => Validator::validate('cover', 'required|image|size:5000'),
            'description' => Validator::validate('description', 'required'),
        ]);
        header('Location: /announcements');
        exit();
    }

    public function editForm($id)
    {
        $announcement = Announcement::find($id);
        return View::render('announcements/update', compact('announcement'));
    }

    public function update($id)
    {
        Announcement::updateOrCreate($id, [
            'title' => $_POST['title'],
            'company_id' => Validator::validate('company_id', 'required|numeric'),
            'candidates_count' => Validator::validate('candidates_count', 'required|numeric'),
            'cover' => Validator::validate('cover', 'required|image|size:5000'),
            'description' => Validator::validate('description', 'required'),
        ]);
        header('Location: /announcements');
        exit();
    }

    public function delete($id)
    {
        Announcement::deleteInstance($id);
        header('Location: /announcements');
        exit();
    }
}

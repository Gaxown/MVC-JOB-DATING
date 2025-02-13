<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Auth;
use App\Models\Announcement;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return View::render('announcements/index', compact('announcements'));
    }

    public function show($id)
    {
        $announcement = Announcement::find($id);
        return View::render('home/details', compact('announcement'));
    }

    public function createForm()
    {
        return View::render('announcements/create');
    }

    public function store()
    {
        Announcement::create([
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'company_id' => Auth::user()->company_id
        ]);
        header('Location: /announcements');
        exit();
    }

    public function editForm($id)
    {
        $announcement = Announcement::find($id);
        return View::render('announcements/edit', compact('announcement'));
    }

    public function update($id)
    {
        Announcement::updateOrCreate($id, [
            'title' => $_POST['title'],
            'content' => $_POST['content']
        ]);
        header('Location: /announcements');
        exit();
    }

    public function deleteAnnouncement($id)
    {
        Announcement::deleteInstance($id);
        header('Location: /announcements');
        exit();
    }
}
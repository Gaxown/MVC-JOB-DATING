<?php

namespace App\Controllers;

// use App\Core;
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
        return View::render('announcements/show', compact('announcement'));
    }

    public function create()
    {
        return View::render('announcements/create');
    }

    public function store()
    {
        $announcement = new Announcement();
        $announcement->title = $_POST['title'];
        $announcement->content = $_POST['content'];
        $announcement->user_id = Auth::user()->id;
        $announcement->save();
        header('Location: /announcements');
        exit();
    }

    public function edit($id)
    {
        $announcement = Announcement::find($id);
        return View::render('announcements/edit', compact('announcement'));
    }

    public function update($id)
    {
        $announcement = Announcement::find($id);
        $announcement->title = $_POST['title'];
        $announcement->content = $_POST['content'];
        $announcement->save();
        header('Location: /announcements');
    }

    public function delete($id)
    {
        $announcement = Announcement::find($id);
        $announcement->delete();
        header('Location: /announcements');
    }
}

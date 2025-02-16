<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\View;
use App\Core\Auth;
use App\Core\Validator;
use App\Models\Announcement;
use App\Models\Company;
use App\Core\Security;

class AnnouncementsController extends Controller
{
    public function index()
    {
        $announcements = Announcement::all();
        return View::render('admin/announcements', compact('announcements'));
    }
    public function removed()
    {
        $announcements = Announcement::onlyTrashed()->get();
        return View::render('admin/removed', compact('announcements'));
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
        $errors = [];
        foreach ($_POST as $key => $value) {
            $_POST[$key] = Security::clean($value);
        }

        $validations = [
            'title' => ['required'],
            'company_id' => ['required', 'numeric'],
            'candidates_count' => ['required', 'numeric'],
            // 'cover' => ['required', 'image', 'size:5000'],
            'description' => ['required'],
        ];

        foreach ($validations as $field => $rules) {
            if (!isset($_POST[$field]) || !Validator::validate($_POST[$field], implode('|', $rules))) {
                $errors[$field] = Validator::getErrors()[$field] ?? ['This field is required'];
            }
        }

        $coverPath = '';
        if (empty($errors)) {
            try {
                if (isset($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
                    $coverPath = $this->handleFileUpload($_FILES['cover'], 'covers');
                }
                $announcement = [
                    'title' => $_POST['title'],
                    'company_id' => $_POST['company_id'],
                    'candidates_count' => $_POST['candidates_count'],
                    'cover' => $coverPath,
                    'description' => $_POST['description'],
                ];

                Announcement::create($announcement);
                header('Location: /admin/announcements');
                exit();
            } catch (\Exception $e) {
                $errors['file'] = [$e->getMessage()];
            }
        }

        return View::render('admin/announcements/create', ['errors' => $errors]);
    }

    // private function handleFileUpload($file, $directory)
    // {
    //     if ($file['error'] === UPLOAD_ERR_NO_FILE) {
    //         return '';
    //     }

    //     if ($file['error'] !== UPLOAD_ERR_OK) {
    //         $errorMessages = [
    //             UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    //             UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    //             UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
    //             UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
    //             UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
    //             UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
    //         ];
    //         throw new \Exception($errorMessages[$file['error']] ?? 'File upload failed');
    //     }

    //     $uploadDir = __DIR__ . '/../../public/uploads/' . $directory;
    //     if (!is_dir($uploadDir)) {
    //         if (!mkdir($uploadDir, 0777, true)) {
    //             throw new \Exception('Failed to create upload directory');
    //         }
    //     }

    //     $filename = uniqid() . '_' . basename($file['name']);
    //     $targetPath = $uploadDir . '/' . $filename;

    //     if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    //         throw new \Exception('Failed to move uploaded file');
    //     }

    //     return '/uploads/' . $directory . '/' . $filename;
    // }
    private function handleFileUpload($file, $directory)
    {
        if ($file['error'] === UPLOAD_ERR_NO_FILE) {
            return '';
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errorMessages = [
                UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
                UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
            ];
            throw new \Exception($errorMessages[$file['error']] ?? 'File upload failed');
        }

        $uploadDir = __DIR__ . '/../../public/uploads/' . $directory;
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new \Exception('Failed to create upload directory');
            }
        }

        $filename = uniqid() . '_' . basename($file['name']);
        $targetPath = $uploadDir . '/' . $filename;

        if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
            throw new \Exception('Failed to move uploaded file');
        }

        // Debugging statement
        error_log("File uploaded to: " . $targetPath);

        return '/uploads/' . $directory . '/' . $filename;
    }

    public function updateForm($id)
    {
        // $companies = Company::all();
        $companies = Company::getAllCompanies();
        $announcement = Announcement::find($id);
        return View::render('admin/announcements/update', compact('announcement', 'companies'));
      
    }

    public function update($id)
    {    $errors = [];
        foreach ($_POST as $key => $value) {
            $_POST[$key] = Security::clean($value);
        }
    
        $validations = [
            'title' => ['required'],
            'company_id' => ['required', 'numeric'],
            'candidates_count' => ['required', 'numeric'],
            // 'cover' => ['required', 'image', 'size:5000'],
            'description' => ['required'],
        ];
    
        foreach ($validations as $field => $rules) {
            if (!isset($_POST[$field]) || !Validator::validate($_POST[$field], implode('|', $rules))) {
                $errors[$field] = Validator::getErrors()[$field] ?? ['This field is required'];
            }
        }
    
        $coverPath = '';
        if (empty($errors)) {
            try {
                if (isset($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
                    $coverPath = $this->handleFileUpload($_FILES['cover'], 'covers');
                }
                $announcement = [
                    'title' => $_POST['title'],
                    'company_id' => $_POST['company_id'],
                    'candidates_count' => $_POST['candidates_count'],
                    'cover' => $coverPath,
                    'description' => $_POST['description'],
                ];
             
              
                // Announcement::updateOrCreate($id , $announcement);
                Announcement::where('id', $id)->update($announcement);
                header('Location: /admin/announcements');
                exit();
            } catch (\Exception $e) {
                $errors['file'] = [$e->getMessage()];
            }
        }
    
        return View::render('admin/announcements/update', ['errors' => $errors]);
      
        exit();
    }

    public function softDeleteAnnouncement($id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->delete();
        header('Location: /admin/announcements');
        exit();
    }

    public function showSoftDeleted()
    {
        $announcements = Announcement::getAllSoftDeletedAnnouncements();
        return View::render('admin/removed', compact('announcements'));
    }
    public function restoreAnnouncement($id)
    {
        $announcement = Announcement::restoreAnnouncement($id);
        header('Location: /admin/removedOffers');
        exit();
    }

    public function search()
    {
        // Vérifier si c'est une requête AJAX
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
            header('HTTP/1.1 400 Bad Request');
            exit('Invalid request');
        }

        // Récupérer et nettoyer le terme de recherche
        $query = isset($_POST['query']) ? Security::clean($_POST['query']) : '';

        // Effectuer la recherche dans la base de données
        $announcements = Announcement::where('title', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('company')
            ->get();

        // Préparer les données pour la réponse JSON
        $results = [];
        foreach ($announcements as $announcement) {
            $results[] = [
                'id' => $announcement->id,
                'title' => $announcement->title,
                'company_name' => $announcement->company->name,
                'description' => substr($announcement->description, 0, 100) . '...',
                'candidates_count' => $announcement->candidates_count,
                'created_at' => date('d M Y', strtotime($announcement->created_at)),
                'cover' => $announcement->cover
            ];
        }

        // Envoyer la réponse JSON
        header('Content-Type: application/json');
        echo json_encode(['announcements' => $results]);
        exit();
    }
}
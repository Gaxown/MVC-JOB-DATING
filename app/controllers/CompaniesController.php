<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Company;
use App\Core\View;
use App\Core\Validator;
use App\Core\Security;

class CompaniesController extends Controller
{

    public function index()
    {
        $companies = Company::getAllCompanies();
        return View::render('admin/companies', compact('companies'));
    }

  

    public function store()
    {
        $errors = [];

        foreach ($_POST as $key => $value) {
            $_POST[$key] = Security::clean($value);
        }

        $validations = [
            'name' => ['required'],
            'description' => ['required'],
            'website' => ['required', 'url'],
            'service' => ['required'],
            'effective' => ['required', 'numeric'],
            'location' => ['required'],
            'capital' => ['required', 'numeric']
        ];

  
        foreach ($validations as $field => $rules) {
  
            if (!isset($_POST[$field]) || !Validator::validate($_POST[$field], implode('|', $rules))) {
                $errors[$field] = Validator::getErrors()[$field] ?? ['This field is required'];
            }
        }

        $logoPath = '';
        $coverPath = '';

        if (empty($errors)) {
            try {
                if (isset($_FILES['logo']) && $_FILES['logo']['size'] > 0) {
                    $logoPath = $this->handleFileUpload($_FILES['logo'], 'logos');
                }
                if (isset($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
                    $coverPath = $this->handleFileUpload($_FILES['cover'], 'covers');
                }

                $company = [
                    'name' => $_POST['name'],
                    'logo' => $logoPath,
                    'cover' => $coverPath,
                    'description' => $_POST['description'],
                    'website' => $_POST['website'],
                    'service' => $_POST['service'],
                    'effective' => $_POST['effective'],
                    'location' => $_POST['location'],
                    'capital' => $_POST['capital']
                ];

                Company::create($company);
                header('Location: /admin/companies');
                exit();
            } catch (\Exception $e) {
                $errors['file'] = [$e->getMessage()];
            }
        }

        return View::render('admin/companies/create', ['errors' => $errors]);
    }

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

        return '/uploads/' . $directory . '/' . $filename;
    }

    public function CreateForm($errors = [])
    {
        var_dump($errors);
        return View::render('admin/companies/create', $errors);
    }
    
    public function updateForm($id)
    {
        $company = Company::find($id);
        return View::render('admin/companies/update', compact('company'));
    }

    public function update($id)
    {
        $errors = [];

        foreach ($_POST as $key => $value) {
            $_POST[$key] = Security::clean($value);
        }

        $validations = [
            'name' => ['required'],
            'description' => ['required'],
            'website' => ['required', 'url'],
            'service' => ['required'],
            'effective' => ['required', 'numeric'],
            'location' => ['required'],
            'capital' => ['required', 'numeric']
        ];

        foreach ($validations as $field => $rules) {
            if (!isset($_POST[$field]) || !Validator::validate($_POST[$field], implode('|', $rules))) {
                $errors[$field] = Validator::getErrors()[$field] ?? ['This field is required'];
            }
        }

        $logoPath = $_POST['existing_logo'] ?? '';
        $coverPath = $_POST['existing_cover'] ?? '';

        if (empty($errors)) {
            try {
                if (isset($_FILES['logo']) && $_FILES['logo']['size'] > 0) {
                    $logoPath = $this->handleFileUpload($_FILES['logo'], 'logos');
                }

                if (isset($_FILES['cover']) && $_FILES['cover']['size'] > 0) {
                    $coverPath = $this->handleFileUpload($_FILES['cover'], 'covers');
                }

                $company = [
                    'name' => $_POST['name'],
                    'logo' => $logoPath,
                    'cover' => $coverPath,
                    'description' => $_POST['description'],
                    'website' => $_POST['website'],
                    'service' => $_POST['service'],
                    'effective' => $_POST['effective'],
                    'location' => $_POST['location'],
                    'capital' => $_POST['capital'],
                ];

                Company::where('id', $id)->update($company);
                header('Location: /admin/companies');
                exit();
            } catch (\Exception $e) {
                $errors['file'] = [$e->getMessage()];
            }
        }

        // return View::render('admin/companies/update', ['errors' => $errors, 'company' => $company]);
        return View::render('admin/companies/create', ['errors' => $errors]);
    }

    public function delete($id)
    {
        Company::deleteInstance($id);
        header('Location: /admin/companies');
        exit();
    }
}

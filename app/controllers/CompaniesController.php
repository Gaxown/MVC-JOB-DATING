<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Company;
use App\Core\View;

class CompaniesController extends Controller
{

    public function index()
    {
        $companies = Company::all();
        return View::render('admin/companies', compact('companies'));
    }

    public function createCompany()
    {
        $company = [
            'name' => $_POST['name'],
            'logo' => $_POST['logo'] ?? '',
            'cover' => $_POST['cover'] ?? '',
            'description' => $_POST['description'] ?? '',
            'website' => $_POST['website'] ?? '',
            'service' => $_POST['service'] ?? '',
            'effective' => $_POST['effective'] ?? '',
            'location' => $_POST['location'] ?? '',
            'capital' => $_POST['capital'] ?? '',
        ];
        Company::create($company);
        header('Location:/admin/companies');
        exit();
    }

    public function CreateForm()
    {
        return View::render('admin/companies/create');
    }
    public function updateForm($id)
    {
        $company = Company::find($id);
        return View::render('admin/companies/update', compact('company'));
    }

    public function updateCompany($id)
    {
        Company::updateOrCreate($id);
        header('Location:/admin/companies');
        exit();
    }

    public function deleteCompany($id)
    {
        // $company = Company::findOrFail($id);
        // $company = Company::find($id);
        // $company->delete();
        Company::deleteInstance($id);
        header('Location:/admin/companies');
        
    }
}

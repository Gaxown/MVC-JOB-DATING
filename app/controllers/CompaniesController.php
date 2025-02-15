<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Company;
use App\Core\View;
use App\Core\Validator;

class CompaniesController extends Controller
{

    public function index()
    {
        $companies = Company::getAllCompanies();
        return View::render('admin/companies', compact('companies'));
    }

    public function store()
    {
        $company = [
            'name' => Validator::validate($_POST['name'], 'required')? $_POST['name'] : '',
            'logo' => Validator::validate($_POST['logo'], 'required|image|size:5000')? $_POST['logo'] : '',
            'cover' => Validator::validate($_POST['cover'], 'required|image|size:5000')? $_POST['cover'] : '',
            'description' => Validator::validate($_POST['description'], 'required')? $_POST['description'] : '',
            'website' => Validator::validate($_POST['website'], 'required')? $_POST['website'] : '',
            'service' => Validator::validate($_POST['service'], 'required')? $_POST['service'] : '',
            'effective' => Validator::validate($_POST['effective'], 'required')? $_POST['effective'] : '',
            'location' => Validator::validate($_POST['location'], 'required')? $_POST['location'] : '',
            'capital' => Validator::validate($_POST['capital'], 'required')? $_POST['capital'] : '',
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

    public function update($id)
    {
        // echo $id . "qsdfghjklm";
        $company = [
            'name' => $_POST['name'],
            'logo' => $_POST['logo'],
            'cover' => $_POST['cover'],
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
    }

    public function delete($id)
    {
        // $company = Company::findOrFail($id);
        // $company = Company::find($id);
        // $company->delete();
        Company::deleteInstance($id);
        header('Location: /admin/companies');
        exit();
    }
}

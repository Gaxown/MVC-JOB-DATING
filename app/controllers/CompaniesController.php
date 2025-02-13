<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Company;
use App\Core\View;

class CompaniesController extends Controller{

    public function index(){
        $companies = Company::all();
        // return View::render('auth/test');
        return View::render('admin/companies', compact('companies'));
    }

    public function createCompany(){
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
        header('Location: companies');
        exit();
    }

    public function showFormCreateCompany(){
        return View::render('admin/addCompany');
    }
    public function showFormUpdateCompany(){
        return View::render('admin/updateCompany');
    }

    public function updateCompany($id){
        Company::updateOrCreate($id);
        header('Location: companies');
        exit();
    }

    public function deleteCompany($id){
        // $company = Company::findOrFail($id);
        // $company = Company::find($id);
        // $company->delete();
        Company::deleteInstance($id);
        header('Location: companies');
        exit();
    }
}
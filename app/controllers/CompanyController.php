<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Company;
use App\Core\View;

class CompanyController extends Controller{
    public function __construct()
    {
        
    }

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
        return $newCompany = Company::create($company);
    }

    public function updateCompany($id){
        $company = Company::findOrFail($id);
        $company->Model::updateOrCreate($id);
    }

    public function deleteCompany($id){
        $company = Company::findOrFail($id);
        $company->delete();
    }
}
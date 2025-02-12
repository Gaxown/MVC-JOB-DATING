<?php
namespace App\models;

use App\Core\Model;
use App\Models\Announcement;

class Company extends Model {
    protected $table = "companies";
    protected $fillable = ['name','logo','cover','description','website','service','effective','location','capital'];
    
    // public static function showCompanies(){
    //     $companies = Model::all();
    //     return $companies;
    // }

    // public function createCompany($name,$logo,$cover,$description,$website,$service,$effective,$location,$capital){
    //     $company = [
    //         'name' => $name,
    //         'logo' => $logo,
    //         'cover' => $cover,
    //         'description' => $description,
    //         'website' => $website,
    //         'service' => $service,
    //         'effective' => $effective,
    //         'location' => $location,
    //         'capital' => $capital,
    //     ];
        
    //     return $newCompany = Model::create($company);
    // }

    public function announcements(){
        $this->hasMany(Announcement::class);
    }

    public $timestamps = true;
}

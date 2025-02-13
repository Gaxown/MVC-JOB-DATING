<?php
namespace App\models;

use App\Core\Model;
use App\Models\Announcement;

class Company extends Model {
    protected $table = "companies";
    protected $fillable = ['name','logo','cover','description','website','service','effective','location','capital'];

    public function announcements(){
        $this->hasMany(Announcement::class);
    }

    public $timestamps = true;
}

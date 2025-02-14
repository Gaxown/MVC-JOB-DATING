<?php

namespace App\models;

use App\Core\Model;
use App\Models\Announcement;

class Company extends Model
{
    protected $table = "companies";
    protected $fillable = ['name', 'logo', 'cover', 'description', 'website', 'service', 'effective', 'location', 'capital'];

    public static function getAllCompanies()
    {
        // return self::all()->orderBy('updated_at', 'desc');
        return self::orderBy('updated_at', 'desc')->get();
    }


    public $timestamps = true;

    public function announcements()
    {
        $this->hasMany(Announcement::class);
    }
}

<?php

namespace App\Models;

use App\Core\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = ['name', 'email', 'logo', 'website'];

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }
}

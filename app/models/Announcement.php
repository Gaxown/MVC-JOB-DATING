<?php

namespace App\Models;

use App\Core\Model;

class Announcement extends Model
{
    // protected $table = 'announcements';
    protected $fillable = ['cover', 'title', 'descripttion', 'condidates_count', 'company_id'];
    protected $timestamps = true;

    public function getAllAnnouncements()
    {
        return self::all();
    }

    public function getAnnouncementById($id)
    {
        return self::findOrFail($id);
    }

    public function createAnnouncement($data)
    {
        return self::create($data);
    }

    public function updateAnnouncement($id, $data)
    {
        $announcement = self::findOrFail($id);
        $announcement->update($data);
        return $announcement;
    }

    public static function deleteAnnouncement($id)
    {
        $announcement = self::findOrFail($id);
        $announcement->delete();
        return $announcement;
    }

    public function getCompany()
    {
        return Company::find($this->company_id);
    }


    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

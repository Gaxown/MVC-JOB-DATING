<?php

namespace App\Models;

use App\Core\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Announcement extends Model
{
    use SoftDeletes;
    protected $fillable = ['cover', 'title', 'descripttion', 'condidates_count', 'company_id'];
    public $timestamps = true;

    public static function getAllAnnouncements()
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

    public static function getAllSoftDeletedAnnouncements()
    {
    return self::onlyTrashed()->get();
    }

    public static function restoreAnnouncement($id)
{
    $announcement = self::onlyTrashed()->findOrFail($id);
    $announcement->restore();
    return $announcement;
}
}

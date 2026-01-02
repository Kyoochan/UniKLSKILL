<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// ClubReport.php

class ClubReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'user_id',
        'title',
        'description',
        'reference_type',
        'reference_id',
        'attachment',
        'advisor_remarks',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function activity()
    {
        return $this->belongsTo(PostedActivity::class, 'reference_id');
    }

    public function announcement()
    {
        return $this->belongsTo(ClubAnnouncement::class, 'reference_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

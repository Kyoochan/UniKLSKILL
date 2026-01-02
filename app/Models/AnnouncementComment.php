<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnnouncementComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'announcement_id',
        'user_id',
        'comment',
        'image', // ✅ optional image path
    ];

    /**
     * Each comment belongs to a user (the commenter)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each comment belongs to an announcement
     */
    public function announcement()
    {
        return $this->belongsTo(ClubAnnouncement::class, 'announcement_id');
    }
}

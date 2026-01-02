<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'posted_by',
        'title',
        'content',
        'attachment',
        'posted_at',
    ];

    protected $casts = [
        'posted_at' => 'datetime',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function postedBy()
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function reports()
    {
        return $this->hasMany(ClubReport::class, 'reference_id')->where('reference_type', 'announcement');
    }

    public function comments()
    {
        return $this->hasMany(AnnouncementComment::class, 'announcement_id');
    }
}

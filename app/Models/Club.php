<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $table = 'clubs';

    protected $fillable = [
        'clubname',
        'clubdesc',
        'profile_picture',
        'banner_image',
        'advisor_id',
    ];

    public function advisor()
    {
        return $this->belongsTo(User::class, 'advisor_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'club_members')
            ->withPivot('position', 'role', 'created_at')
            ->withTimestamps();
    }

    public function joinRequests()
    {
        return $this->hasMany(ClubJoinRequest::class, 'club_id');
    }

    public function activityProposals()
    {
        return $this->hasMany(ActivityProposal::class, 'club_id');
    }

    public function postedActivities()
    {
        return $this->hasMany(PostedActivity::class, 'club_id')
            ->orderBy('posted_at', 'desc');
    }

    public function announcements()
    {
        return $this->hasMany(ClubAnnouncement::class);
    }

    public function socials()
    {
        return $this->hasMany(ClubSocial::class);
    }
}

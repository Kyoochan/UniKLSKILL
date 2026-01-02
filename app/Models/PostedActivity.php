<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostedActivity extends Model
{
    use HasFactory;

    protected $fillable = [
    'proposal_id',
    'club_id',
    'activity_title',
    'activity_description',
    'images',
    'posted_at',
    'level',
    'dna_category',
    'ghocs_element',
    'activity_date',
    'activity_date_end',
    'location',
    'budget',
    'additional_info',
];
    protected $casts = [
        'images' => 'array',
        'posted_at' => 'datetime',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function proposal()
    {
        return $this->belongsTo(ActivityProposal::class);
    }

    public function reports()
    {
        return $this->hasMany(ClubReport::class, 'reference_id')->where('reference_type', 'activity');
    }

    public function comments()
    {
        return $this->hasMany(ActivityComment::class, 'activity_id');
    }
}

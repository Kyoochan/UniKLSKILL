<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'proposed_by',
        'activity_title',
        'activity_description',
        'activity_date',
        'activity_date_end',
        'level',
        'dna_category',
        'ghocs_element',
        'location',
        'budget',
        'additional_info',
        'proposal_file',
        'status',
        'remarks',
        'poster_image',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function proposer()
    {
        return $this->belongsTo(User::class, 'proposed_by');
    }
}

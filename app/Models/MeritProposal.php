<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeritProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_type',
        'reference_id',
        'title',
        'ghocs_element',
        'level',
        'dna_category',
        'activity_date',
        'achievement_level',
        'description',
        'evidence',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProposalNews extends Model
{
    use HasFactory;

    protected $fillable = [
        'proposal_news_name',
        'proposal_news_description',
        'image',
        'proposal_pdf',
        'budget',
        'additional_description',
        'ghocs_element',
        'level',
        'location',
        'dna_category',
        'activity_date',
        'activity_date_end',
        'user_id', // if you track who submitted it
        'status',
    ];

    // Add date casting
    protected $casts = [
        'activity_date' => 'date',
        'activity_date_end' => 'date',
    ];
}

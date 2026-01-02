<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'news_name',
        'news_description',
        'image',
        'author',
        'published_at',
        'ghocs_element',
        'level',
        'location',
        'dna_category',
        'activity_date',
        'activity_date_end',
    ];
}

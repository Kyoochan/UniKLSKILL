<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'comment',
        'image', // ✅ allow saving image path
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activity()
    {
        return $this->belongsTo(PostedActivity::class);
    }
}

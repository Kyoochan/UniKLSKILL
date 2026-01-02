<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'pdf_file',
        'subject_name',
        'subject_points',
        'approval_status',
        'secretary_remark'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

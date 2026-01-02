<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClubProposal extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'clubname',
        'clubdesc',
        'proposal_pdf',
        'status',
        'remarks',
    ];
}

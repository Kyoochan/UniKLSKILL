<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'points'];

    public function proposals() {
        return $this->belongsToMany(SkillProposal::class, 'proposal_subject')
                    ->withPivot('points')
                    ->withTimestamps();
    }
}

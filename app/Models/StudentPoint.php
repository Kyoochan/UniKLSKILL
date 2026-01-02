<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'skill_development',
        'dna_active_programme',
        'dna_sports_recreation',
        'dna_entrepreneur',
        'dna_global',
        'dna_graduate',
        'dna_leadership',
        'achievement_representative',
        'achievement_participate',
        'achievement_special_award',
        'achievement_international_short',
        'achievement_international_full',
        'achievement_exchange_short',
        'achievement_exchange_full',
        'ghocs_spiritual',
        'ghocs_physical',
        'ghocs_intellectual',
        'ghocs_career',
        'ghocs_emotional',
        'ghocs_social',
        'management_skills',
        'issued_date',
    ];

    protected $casts = [
        'issued_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getDNAPointsAttribute()
    {
        return
            $this->dna_active_programme +
            $this->dna_sports_recreation +
            $this->dna_entrepreneur +
            $this->dna_global +
            $this->dna_graduate +
            $this->dna_graduate +
            $this->dna_leadership;
    }

    public function getExcellencePointsAttribute()
    {
        return
            $this->achievement_representative +
            $this->achievement_participate +
            $this->achievement_special_award +
            $this->achievement_international_short +
            $this->achievement_international_full +
            $this->achievement_exchange_short +
            $this->achievement_exchange_full;
    }

    public function getSC1Attribute()
    {
        return $this->dna_active_programme
             + $this->dna_sports_recreation
             + $this->dna_leadership;
    }

    public function getSC2Attribute()
    {
        return $this->dna_active_programme
             + $this->dna_sports_recreation
             + $this->dna_global
             + $this->dna_graduate
             + $this->dna_leadership;
    }

    public function getSC3Attribute()
    {
        return $this->dna_active_programme
             + $this->dna_sports_recreation
             + $this->dna_global
             + $this->dna_graduate;
    }

    public function getSC4Attribute()
    {
        return $this->dna_entrepreneur
             + $this->dna_graduate;
    }

    public function getSC5Attribute()
    {
        return $this->dna_entrepreneur
             + $this->dna_leadership;
    }


    //Cummulative GHOCS points total
    public function getTotalPointsAttribute()
    {
        return
            $this->dna_active_programme +
            $this->dna_sports_recreation +
            $this->dna_entrepreneur +
            $this->dna_global +
            $this->dna_graduate +
            $this->dna_leadership +

            $this->ghocs_spiritual +
            $this->ghocs_physical +
            $this->ghocs_intellectual +
            $this->ghocs_career +
            $this->ghocs_emotional +
            $this->ghocs_social +

            $this->achievement_representative +
            $this->achievement_participate +
            $this->achievement_special_award +
            $this->achievement_international_short +
            $this->achievement_international_full +
            $this->achievement_exchange_short +
            $this->achievement_exchange_full +

            $this->management_skills +
            $this->skill_development;
    }

    public function transcriptData()
    {
        return [
            'dna' => [
                'Active Programme' => $this->dna_active_programme,
                'Sports & Recreation' => $this->dna_sports_recreation,
                'Entrepreneur' => $this->dna_entrepreneur,
                'Global' => $this->dna_global,
                'Graduate' => $this->dna_graduate,
                'Leadership' => $this->dna_leadership,
            ],
            'ghocs' => [
                'Spiritual' => $this->ghocs_spiritual,
                'Physical' => $this->ghocs_physical,
                'Intellectual' => $this->ghocs_intellectual,
                'Career' => $this->ghocs_career,
                'Emotional' => $this->ghocs_emotional,
                'Social' => $this->ghocs_social,
            ],
            'achievement' => [
                'Representative' => $this->achievement_representative,
                'Participate' => $this->achievement_participate,
                'Special Award' => $this->achievement_special_award,
                'International Short Sem' => $this->achievement_international_short,
                'International Full Sem' => $this->achievement_international_full,
                'Exchange Short Sem' => $this->achievement_exchange_short,
                'Exchange Full Sem' => $this->achievement_exchange_full,
            ],
            'sc' => [
                'SC1' => $this->SC1,
                'SC2' => $this->SC2,
                'SC3' => $this->SC3,
                'SC4' => $this->SC4,
                'SC5' => $this->SC5,
            ],
            'management_skills' => $this->management_skills,
            'skill_development' => $this->skill_development,
            'total_points' => $this->total_points,
            'issued_date' => $this->issued_date,
        ];
    }

    public function scData() // graph data for SC1 to SC5 easier
    {
        return [
            'SC1' => $this->SC1,
            'SC2' => $this->SC2,
            'SC3' => $this->SC3,
            'SC4' => $this->SC4,
            'SC5' => $this->SC5,
        ];
    }

    public function getManagementSkillsAttribute()
    {
        // User model is available through relationship
        $user = $this->user;

        // Get all clubs user belongs to
        $clubs = $user->clubMemberships()->get();

        $points = 0;

        foreach ($clubs as $club) {
            $pivot = $club->pivot;

            // If high committee
            if ($pivot->position === 'high_committee') {
                $points += 10;
            }
            //normal member
            else {
                $points += 5;
            }
        }

        return $points;
    }
}

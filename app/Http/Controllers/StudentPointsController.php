<?php

namespace App\Http\Controllers;

use App\Models\MeritProposal;
use App\Models\StudentPoint;
use Illuminate\Http\Request;

class StudentPointController extends Controller
{
    /**
     * Allocate points to a student from an approved merit proposal
     */
    public function allocate(MeritProposal $proposal)
    {
        // Only allocate if approved
        if ($proposal->status !== 'approved') {
            return redirect()->back()->with('error', 'Proposal is not approved yet.');
        }

        $user = $proposal->user;

        // Get or create student points record
        $studentPoints = StudentPoint::firstOrCreate(
            ['user_id' => $user->id],
            ['issued_date' => now()]
        );

        /**
         * 1. DNA category points
         * Assuming each activity or reference has predefined points per category
         */
        switch ($proposal->dna_category) {
            case 'Active Programme':
                $studentPoints->dna_active_programme += 1; // or points from proposal
                break;
            case 'Sports & Recreation':
                $studentPoints->dna_sports_recreation += 1;
                break;
            case 'Entrepreneur':
                $studentPoints->dna_entrepreneur += 1;
                break;
            case 'Global':
                $studentPoints->dna_global += 1;
                break;
            case 'Graduate':
                $studentPoints->dna_graduate += 1;
                break;
            case 'Leadership':
                $studentPoints->dna_leadership += 1;
                break;
        }

        /**
         * 2. GHOCS element points
         */
        switch ($proposal->ghocs_element) {
            case 'Spiritual':
                $studentPoints->ghocs_spiritual += 1;
                break;
            case 'Physical':
                $studentPoints->ghocs_physical += 1;
                break;
            case 'Intellectual':
                $studentPoints->ghocs_intellectual += 1;
                break;
            case 'Career':
                $studentPoints->ghocs_career += 1;
                break;
            case 'Emotional':
                $studentPoints->ghocs_emotional += 1;
                break;
            case 'Social':
                $studentPoints->ghocs_social += 1;
                break;
        }

        /**
         * 3. Achievement points (weighted example)
         */
        switch ($proposal->achievement_level) {
            case 'Representative':
                $studentPoints->achievement_representative += 10;
                break;
            case 'Participate':
                $studentPoints->achievement_participate += 5;
                break;
            case 'Special Award':
                $studentPoints->achievement_special_award += 20;
                break;
            case 'International Short Sem':
                $studentPoints->achievement_international_short += 20;
                break;
            case 'International Full Sem':
                $studentPoints->achievement_international_full += 25;
                break;
            case 'Exchange Short Sem':
                $studentPoints->achievement_exchange_short += 20;
                break;
            case 'Exchange Full Sem':
                $studentPoints->achievement_exchange_full += 25;
                break;
        }

        // Optional: Add skill development and management skills if applicable
        // $studentPoints->skill_development += X;
        // $studentPoints->management_skills += Y;

        $studentPoints->save();

        return redirect()->back()->with('success', 'Points allocated successfully.');
    }


}

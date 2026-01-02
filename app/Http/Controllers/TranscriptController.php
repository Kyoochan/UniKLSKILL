<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StudentPoint;
use App\Models\MeritProposal;
use Illuminate\Support\Facades\Auth;

class TranscriptController extends Controller
{
    public function show($id)
    {
        // Optional security check
        if (Auth::id() != $id && Auth::user()->userRole !== 'admin') {
            abort(403);
        }

        // Student info
        $student = User::findOrFail($id);

        // Student points (ensure not null)
        $studentPoints = StudentPoint::firstOrCreate(
            ['user_id' => $id],
            ['issued_date' => now()]
        );

        // ✅ APPROVED ACTIVITIES (THIS WAS MISSING)
        $approvedActivities = MeritProposal::where('user_id', $id)
            ->where('status', 'approved')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view(
            '5_curriculumpage_module.transcript',
            compact('student', 'studentPoints', 'approvedActivities')
        );
    }
}

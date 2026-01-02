<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostedActivity;
use App\Models\Club;

class ActivityController extends Controller
{
    /**
     * Display a posted activity along with its club, comments, and reports.
     */
    public function show($activity_id)
    {
        // Load the activity with related club, comments, and reports
        $activity = PostedActivity::with([
            'club',
            'comments.user',   // Assuming comments have a 'user' relationship
            'reports'
        ])->findOrFail($activity_id);

        // The club is already loaded via the relationship
        $club = $activity->club;

        return view('3_clubpage_module.viewactivity', compact('activity', 'club'));
    }
}

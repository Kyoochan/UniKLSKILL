<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubAnnouncement;
use App\Models\ClubReport;
use App\Models\Notification;
use App\Models\PostedActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubReportController extends Controller
{
    public function index()
    {
        $advisorId = Auth::id();

        // Find the club assigned to this advisor
        $club = Club::where('advisor_id', $advisorId)->first();

        if (! $club) {
            return redirect()->back()->with('error', 'You are not assigned to any club.');
        }

        // Fetch all activities, announcements, and reports for that club
        $activities = PostedActivity::where('club_id', $club->id)->get();
        $announcements = ClubAnnouncement::where('club_id', $club->id)->get();
        $reports = ClubReport::where('club_id', $club->id)->get();

        return view('3_clubpage_module.viewreport', compact('club', 'activities', 'announcements', 'reports'));
    }

    /**
     * Show the report submission form for a specific club.
     */
    public function showForm($clubId)
    {
        $club = Club::findOrFail($clubId);

        // Get all related activities and announcements
        $activities = PostedActivity::where('club_id', $clubId)->get();
        $announcements = ClubAnnouncement::where('club_id', $clubId)->get();

        // Get all reports submitted for this club
        $reports = ClubReport::where('club_id', $clubId)->get();

        return view('3_clubpage_module.submitreport', compact('club', 'activities', 'announcements', 'reports'));
    }

    /**
     * Store a newly submitted club report.
     */
    public function store(Request $request, $clubId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'reference_type' => 'nullable|string|in:announcement,activity',
            'reference_id' => 'nullable|integer',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:4096',
        ]);

        $club = Club::findOrFail($clubId); // get club to know advisor

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('club_reports', 'public');
        }

        ClubReport::create([
            'club_id' => $clubId,
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'reference_type' => $validated['reference_type'],
            'reference_id' => $validated['reference_id'],
            'attachment' => $path,
        ]);

        // 🔔 Notify the advisor
        if ($club->advisor_id) {
            Notification::create([
                'user_id' => $club->advisor_id,
                'type' => 'club_report_submitted',
                'message' => "A new club report titled '{$validated['title']}' has been submitted for '{$club->clubname}'.",
            ]);
        }

        return redirect()->route('club.show', $clubId)
            ->with('success', 'Club report submitted successfully!');
    }

    public function viewReport($clubId)
    {
        $club = Club::findOrFail($clubId);

        $activities = PostedActivity::where('club_id', $club->id)->get();
        $announcements = ClubAnnouncement::where('club_id', $club->id)->get();
        $reports = ClubReport::where('club_id', $club->id)->get();

        return view('3_clubpage_module.viewreport', compact('club', 'activities', 'announcements', 'reports'));
    }

    public function remarkForm(ClubReport $report)
    {
        $club = Club::find($report->club_id);

        return view('3_clubpage_module.createremark', compact('report', 'club'));
    }

    public function storeRemark(Request $request, ClubReport $report)
    {
        $request->validate([
            'advisor_remarks' => 'required|string|max:1000',
        ]);

        $report->advisor_remarks = $request->advisor_remarks;
        $report->save();

        // Redirect to the view report page for this club
        return redirect()->route('report.viewreport', $report->club_id)
            ->with('success', 'Remark added successfully!');
    }
}

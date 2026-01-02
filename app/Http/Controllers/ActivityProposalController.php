<?php

namespace App\Http\Controllers;

use App\Models\ActivityProposal;
use App\Models\Club;
use App\Models\Notification;
use App\Models\PostedActivity;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ActivityProposalController extends Controller
{
    // Show the proposal form
    public function show($club_id)
    {
        $club = Club::findOrFail($club_id);

        // Ensure only high committee members can propose
        $isHighCommittee = $club->members->contains(function ($member) {
            return $member->id === Auth::id() && $member->pivot->position === 'high_committee';
        });

        if (! $isHighCommittee) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Load proposals for the club
        $proposals = ActivityProposal::where('club_id', $club_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('3_clubpage_module.proposeactivity', compact('club', 'proposals'));
    }

    // ✅ Updated STORE with all new fields
    public function store(Request $request, $club_id)
    {
        $request->validate([
            'activity_title' => 'required|string|max:255',
            'activity_description' => 'required|string',

            'activity_date' => 'required|date|after_or_equal:today',
            'activity_date_end' => 'nullable|date|after_or_equal:activity_date',

            // Dropdown fields
            'level' => 'required|string',
            'dna_category' => 'required|string',
            'ghocs_element' => 'required|string',

            'location' => 'required|string|max:255',
            'budget' => 'nullable|string',
            'additional_info' => 'nullable|string',

            'proposal_file' => 'required|mimes:pdf|max:5120|min:10',
            'poster_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $club = Club::findOrFail($club_id);

        // Save uploaded PDF to storage/app/public/proposal_pdfs
        $filePath = $request->file('proposal_file')->store('proposal_pdfs', 'public');
        $posterPath = null;

        if ($request->hasFile('poster_image')) {
            $posterPath = $request->file('poster_image')
                ->store('activity_posters', 'public');
        }

        // ✅ Save the proposal record with new fields
        $proposal = ActivityProposal::create([
            'club_id' => $club_id,
            'proposed_by' => Auth::id(),
            'activity_title' => $request->activity_title,
            'activity_description' => $request->activity_description,

            'activity_date' => $request->activity_date,
            'activity_date_end' => $request->activity_date_end,

            'level' => $request->level,
            'dna_category' => $request->dna_category,
            'ghocs_element' => $request->ghocs_element,

            'location' => $request->location,
            'budget' => $request->budget,
            'additional_info' => $request->additional_info,

            'proposal_file' => $filePath,
            'poster_image' => $posterPath,
            'status' => 'Pending',
        ]);

        // Notify advisor
        if ($club->advisor_id) {
            Notification::create([
                'user_id' => $club->advisor_id,
                'type' => 'activity_proposal_submitted',
                'message' => 'A new activity proposal "'.$proposal->activity_title.'" was submitted for '.$club->clubname.'.',
            ]);
        }

        return redirect()->route('proposeactivity.show', $club_id)
            ->with('success', 'Activity proposal submitted successfully!');
    }

    public function manage($club_id)
    {
        $club = Club::findOrFail($club_id);

        if (Auth::id() !== $club->advisor_id) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $proposals = $club->activityProposals()->with('proposer')->latest()->paginate(5);

        return view('3_clubpage_module.manageactivity', compact('club', 'proposals'));
    }

    public function approve($club_id, $proposal_id)
    {
        $proposal = ActivityProposal::where('club_id', $club_id)->findOrFail($proposal_id);

        $proposal->update(['status' => 'Approved']);

        Notification::create([
            'user_id' => $proposal->proposed_by,
            'type' => 'activity_proposal_status',
            'message' => 'Your activity proposal "'.$proposal->activity_title.'" has been approved. Please manually post the activity from Manage Club Activity -> View Submission Status tab',
        ]);

        return back()->with('success', 'Proposal approved successfully.');
    }

    public function reject(Request $request, $club_id, $proposal_id)
    {
        // Validate remark input
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $proposal = ActivityProposal::where('club_id', $club_id)
            ->findOrFail($proposal_id);

        // Update status + remarks
        $proposal->update([
            'status' => 'Rejected',
            'remarks' => $request->remarks,
        ]);

        // Notify proposer with remark
        Notification::create([
            'user_id' => $proposal->proposed_by,
            'type' => 'activity_proposal_rejected',
            'message' => 'Your activity proposal "'.$proposal->activity_title.
                         '" has been rejected. Remark: '.$request->remarks,
        ]);

        return back()->with('success', 'Proposal rejected with remarks.');
    }

    public function destroy($club_id, $proposal_id)
    {
        $proposal = ActivityProposal::where('club_id', $club_id)->findOrFail($proposal_id);

        if ($proposal->proposal_file && Storage::exists('public/'.$proposal->proposal_file)) {
            Storage::delete('public/'.$proposal->proposal_file);
        }

        if ($proposal->poster_image && Storage::exists('public/'.$proposal->poster_image)) {
            Storage::delete('public/'.$proposal->poster_image);
        }

        $proposal->delete();

        return back()->with('success', 'Proposal deleted successfully.');
    }

    public function showPostActivity($proposal_id)
    {
        $proposal = ActivityProposal::findOrFail($proposal_id);

        if ($proposal->status !== 'Approved') {
            return redirect()->back()->with('error', 'Only approved proposals can be posted.');
        }

        return view('3_clubpage_module.postactivity', compact('proposal'));
    }

    public function storePostedActivity(Request $request, $proposal_id)
    {
        $proposal = ActivityProposal::findOrFail($proposal_id);

        if ($proposal->status !== 'Approved') {
            return back()->with('error', 'Only approved proposals can be posted.');
        }

        $request->validate([
            'poster_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $imagePaths = [];

        // Check if a new poster was uploaded
        if ($request->hasFile('poster_image')) {
            // Store new poster image
            $imagePaths[] = $request->file('poster_image')->store('activity_images', 'public');
        } elseif ($proposal->poster_image) {
            // Keep existing poster image
            $imagePaths[] = $proposal->poster_image;
        }

        // Create the PostedActivity
        PostedActivity::create([
            'proposal_id' => $proposal->id,
            'club_id' => $proposal->club_id,
            'activity_title' => $proposal->activity_title,
            'activity_description' => $proposal->activity_description,
            'images' => json_encode($imagePaths),
            'posted_at' => Carbon::now(),
            'level' => $proposal->level,
            'dna_category' => $proposal->dna_category,
            'ghocs_element' => $proposal->ghocs_element,
            'activity_date' => $proposal->activity_date,
            'activity_date_end' => $proposal->activity_date_end,
            'location' => $proposal->location,
            'budget' => $proposal->budget,
            'additional_info' => $proposal->additional_info,
        ]);

        return redirect()->route('club.show', $proposal->club_id)
            ->with('success', 'Activity successfully posted.');
    }

    public function viewProposed($id)
    {
        $proposal = \App\Models\ActivityProposal::findOrFail($id); // your model name

        return view('3_clubpage_module.viewproposeactivity', compact('proposal'));
    }

    public function destroyPostedActivity($club_id, $posted_activity_id)
    {
        $activity = PostedActivity::where('club_id', $club_id)
            ->findOrFail($posted_activity_id);

        // Delete images safely
        if (is_array($activity->images)) {
            foreach ($activity->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        $activity->delete();

        return redirect()
            ->route('club.show', $club_id)
            ->with('success', 'Posted activity deleted successfully.');
    }
}

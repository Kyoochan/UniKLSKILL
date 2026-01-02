<?php

namespace App\Http\Controllers;

use App\Models\MeritProposal;
use App\Models\News;
use App\Models\Notification;
use App\Models\PostedActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MeritProposalController extends Controller
{
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Get IDs of clubs the user belongs to
        // Use table name to avoid ambiguous column errors
        $clubIds = $user->clubMemberships()->pluck('clubs.id')->toArray();

        // Fetch activities only for these clubs that have GHOCS, level, and DNA set
        $activities = PostedActivity::with('club')
            ->whereIn('club_id', $clubIds)
            ->whereNotNull('ghocs_element')
            ->whereNotNull('level')
            ->whereNotNull('dna_category')
            ->get();

        // Fetch news similarly
        $news = News::whereNotNull('ghocs_element')
            ->whereNotNull('level')
            ->whereNotNull('dna_category')
            ->get();

        $myRequests = MeritProposal::where('user_id', Auth::id())->latest()->get();

        return view('5_curriculumpage_module.meritrequest', compact('activities', 'news', 'myRequests'));

    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_type' => 'nullable|string',    // 'activity' or 'news' or null
            'reference_id' => 'nullable|integer',

            // Manual fields (required only if no reference chosen)
            'title' => 'required_without:reference_id|string|max:255',
            'ghocs_element' => 'required_without:reference_id|string|max:255',
            'level' => 'required_without:reference_id|string|max:255',
            'dna_category' => 'required_without:reference_id|string|max:255',
            'activity_date' => 'required_without:reference_id|date',

            // Always required
            'achievement_level' => 'required|string|max:255',
            'description' => 'required|string',
            'evidence' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        // Upload evidence
        $evidencePath = $request->file('evidence')->store('evidence', 'public');

        $proposal = new MeritProposal;
        $proposal->user_id = Auth::id();

        // If student referenced an activity or news
        if ($request->reference_id) {
            if ($request->reference_type === 'activity') {
                $ref = PostedActivity::find($request->reference_id);
                $proposal->title = $ref->activity_title ?? null;
            } else {
                $ref = News::find($request->reference_id);
                $proposal->title = $ref->news_name ?? null;
            }

            $proposal->ghocs_element = $ref->ghocs_element;
            $proposal->level = $ref->level;
            $proposal->dna_category = $ref->dna_category;
            $proposal->activity_date = $ref->activity_date ?? $ref->created_at;
        } else {
            // Manual entry
            $proposal->title = $request->title;
            $proposal->ghocs_element = $request->ghocs_element;
            $proposal->level = $request->level;
            $proposal->dna_category = $request->dna_category;
            $proposal->activity_date = $request->activity_date;
        }

        $proposal->achievement_level = $request->achievement_level;
        $proposal->description = $request->description;
        $proposal->evidence = $evidencePath;

        $proposal->save();

        Notification::create([
            'user_id' => Auth::id(),
            'type' => 'proposal_submitted',
            'message' => "Your merit proposal '{$proposal->title}' has been submitted successfully.",
        ]);

        $secretaries = \App\Models\User::where('userRole', 'secretary')->get();

        foreach ($secretaries as $secretary) {
             Notification::create([
                'user_id' => $secretary->id,
                'type' => 'proposal_pending_approval',
                'message' => "A new merit proposal '{$proposal->title}' has been submitted by {$proposal->user->name} and requires your review.",
            ]);
        }

        return redirect()->route('merit.create')
            ->with('success', 'Merit proposal successfully submitted.');
    }

    public function show($id)
    {
        $proposal = MeritProposal::findOrFail($id);

        return view('5_curriculumpage_module.meritview', compact('proposal'));
    }

    public function pending()
    {
        $proposals = MeritProposal::where('status', 'pending')->get();

        return view('5_curriculumpage_module.meritmanage', compact('proposals'));
    }

    public function approve($id)
    {
        $proposal = MeritProposal::findOrFail($id);

        // Update status
        $proposal->status = 'approved';
        $proposal->admin_comment = null;
        $proposal->save();

        // ----- AUTOMATIC POINT ALLOCATION -----

        // Get or create student points record
        $studentPoints = \App\Models\StudentPoint::firstOrCreate(
            ['user_id' => $proposal->user_id],
            ['issued_date' => now()]
        );

        // Ensure all fields are at least 0 (prevents null + 1 errors)
        foreach ($studentPoints->getFillable() as $field) {
            if ($studentPoints->$field === null) {
                $studentPoints->$field = 0;
            }
        }

        /*-----------------------------------------
        | 1. DNA Category Points
        -----------------------------------------*/
        switch ($proposal->dna_category) {
            case 'Active Programme':
                $studentPoints->dna_active_programme += 1;
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

        /*-----------------------------------------
        | 2. GHOCS Element Points
        -----------------------------------------*/
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

        /*-----------------------------------------
        | 3. Achievement Level Points (Weighted)
        -----------------------------------------*/
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

        // Save updated points
        $studentPoints->save();

        // ✅ Notify student that proposal was approved
        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'proposal_approved',
            'message' => "Your merit proposal '{$proposal->title}' has been approved. Points have been updated.",
        ]);

        // Return
        return redirect()->route('merit.pending')
            ->with('success', 'Proposal approved and student points updated.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'admin_comment' => 'required|string|min:5',
        ]);

        $proposal = MeritProposal::findOrFail($id);

        $proposal->status = 'rejected';
        $proposal->admin_comment = $request->admin_comment;
        $proposal->save();

        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'proposal_rejected',
            'message' => "Your merit proposal '{$proposal->title}' was rejected. Comment: '{$proposal->admin_comment}'",
        ]);

        return redirect()->route('merit.pending')
            ->with('success', 'Proposal rejected with comment.');
    }

    public function rejectForm($id)
    {
        $proposal = MeritProposal::findOrFail($id);

        return view('5_curriculumpage_module.reject_merit', compact('proposal'));
    }


}

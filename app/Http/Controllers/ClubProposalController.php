<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClubProposalController extends Controller
{
    // Display club proposals
    public function index()
    {

        $template = DB::table('proposal_templates')->latest()->first();

        $pendingProposals = DB::table('club_proposals')
            ->join('users', 'club_proposals.student_id', '=', 'users.id')
            ->select(
                'club_proposals.id',
                'club_proposals.clubname',
                'club_proposals.clubdesc',
                'club_proposals.proposal_pdf',
                'club_proposals.status',
                'club_proposals.created_at',
                'users.name as student_name'
            )
            ->orderBy('club_proposals.created_at', 'asc')
            ->paginate(10);

        return view('3_clubpage_module.clubrequest', compact('template', 'pendingProposals'));
    }

    // Show  list of submitted proposals
    public function create()
    {
        $studentId = Auth::id();

        $proposals = DB::table('club_proposals')
            ->where('student_id', $studentId)
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('3_clubpage_module.clubpropose', compact('proposals'));
    }

    // Store new proposal.
    public function store(Request $request)
    {
        $request->validate([
            'clubname' => 'required|string|max:255',
            'clubdesc' => 'required|string',
            'proposal_pdf' => 'required|mimes:pdf|max:5120|min:10',
        ]);

        $pdfPath = $request->file('proposal_pdf')->store('club_proposals', 'public');

        $proposalId = DB::table('club_proposals')->insertGetId([
            'student_id' => Auth::id(),
            'clubname' => $request->clubname,
            'clubdesc' => $request->clubdesc,
            'proposal_pdf' => $pdfPath,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admins = DB::table('users')->where('userRole', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'new_proposal',
                'message' => "A new club proposal '{$request->clubname}' has been submitted by ".Auth::user()->name,
            ]);
        }

        return redirect()
            ->route('club.propose')
            ->with('success', 'Club proposal submitted successfully!');
    }

    // Approve a proposal
    public function approve($id)
    {
        $proposal = DB::table('club_proposals')->where('id', $id)->first();

        if (! $proposal) {
            return redirect()->route('club.request')->with('error', 'Proposal not found.');
        }

        DB::table('club_proposals')->where('id', $id)->update([
            'status' => 'approved',
            'updated_at' => now(),
        ]);

        Notification::create([
            'user_id' => $proposal->student_id,
            'type' => 'proposal_approved',
            'message' => "Your club proposal '{$proposal->clubname}' has been approved!",
        ]);

        return redirect()->route('club.request')->with('success', 'Proposal approved successfully.');
    }

    // Reject  proposal
    // Reject a proposal with remarks
    public function reject(Request $request, $id)
    {
        // Validate that a remark is provided
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $proposal = DB::table('club_proposals')->where('id', $id)->first();

        if (! $proposal) {
            return redirect()->route('club.request')->with('error', 'Proposal not found.');
        }

        // Update status to rejected and save the remarks
        DB::table('club_proposals')->where('id', $id)->update([
            'status' => 'rejected',
            'remarks' => $request->remarks,
            'updated_at' => now(),
        ]);

        // Notify the student
        Notification::create([
            'user_id' => $proposal->student_id,
            'type' => 'proposal_rejected',
            'message' => "Your club proposal '{$proposal->clubname}' has been rejected. Reason: ".$request->remarks,
        ]);

        return redirect()->route('club.request')->with('success', 'Proposal rejected successfully with remarks.');
    }

    // Delete a proposal.
    public function destroy($id)
    {
        DB::table('club_proposals')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Proposal deleted successfully!');
    }
}

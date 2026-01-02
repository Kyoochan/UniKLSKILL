<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\SkillProposal;
use App\Models\StudentPoint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillProposalController extends Controller
{
    public function create()
    {
        $subjects = [
            ['name' => 'Bahasa Melayu', 'points' => 5],
            ['name' => 'Arabic', 'points' => 5],
            ['name' => 'French', 'points' => 5],
            ['name' => 'Italian', 'points' => 5],
            ['name' => 'Korean Language', 'points' => 5],
            ['name' => 'Mandarin', 'points' => 5],
            ['name' => 'Spanish', 'points' => 5],

        ];

        $proposals = SkillProposal::where('user_id', Auth::id())->latest()->get();

        return view('5_curriculumpage_module.skillpointrequest', compact('subjects', 'proposals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'pdf_file' => 'required|mimes:pdf|max:10240',
            'subject_name' => 'required|string',
            'subject_points' => 'required|integer',
        ]);

        $pdfPath = $request->file('pdf_file')->store('proposals', 'public');

        SkillProposal::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'pdf_file' => $pdfPath,
            'subject_name' => $request->subject_name,
            'subject_points' => $request->subject_points,
        ]);

        $secretaries = User::where('userRole', 'secretary')->get();

        foreach ($secretaries as $secretary) {
            Notification::create([
                'user_id' => $secretary->id,
                'type' => 'skill_proposal_submitted',
                'message' => "New skill proposal '{$proposal->title}' submitted by a student.",
            ]);
        }

        return redirect()->back()->with('success', 'Proposal submitted successfully!');
    }

    public function secretaryIndex()
    {
        $proposals = SkillProposal::latest()->get();

        return view('5_curriculumpage_module.skillpointmanage', compact('proposals'));
    }

    public function approve($id)
    {
        $proposal = SkillProposal::findOrFail($id);

        // ⛔ Prevent double approval
        if ($proposal->approval_status === 'approved') {
            return back()->with('success', 'This proposal was already approved.');
        }

        // 1️⃣ Update proposal status
        $proposal->update([
            'approval_status' => 'approved',
            'secretary_remark' => null,
        ]);

        // 2️⃣ Find or create student_points record
        $studentPoint = StudentPoint::firstOrCreate(
            ['user_id' => $proposal->user_id],
            ['skill_development' => 0]
        );

        // 3️⃣ Add points to skill_development
        $studentPoint->update([
            'skill_development' => $studentPoint->skill_development + $proposal->subject_points,
        ]);

        // 4️⃣ Notify student
        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'skill_proposal_approved',
            'message' => "Your skill proposal '{$proposal->title}' has been approved. {$proposal->subject_points} points were added to Skill Development.",
        ]);

        return back()->with('success', 'Proposal approved and points added.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'secretary_remark' => 'required|string',
        ]);

        $proposal = SkillProposal::findOrFail($id);

        $proposal->update([
            'approval_status' => 'rejected',
            'secretary_remark' => $request->secretary_remark,
        ]);

        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'skill_proposal_rejected',
            'message' => "Your skill proposal '{$proposal->title}' was rejected. Remark: {$request->secretary_remark}",
        ]);

        return back()->with('success', 'Proposal rejected.');
    }
}

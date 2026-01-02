<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProposalTemplate;
use Illuminate\Support\Facades\Storage;

class ProposalTemplateController extends Controller
{
    // Show upload form (admin only)
public function index()
{
    $template = \App\Models\ProposalTemplate::latest()->first();

    // ✅ Fetch all pending club proposals
    $pendingProposals = \DB::table('club_proposals')
        ->join('users', 'club_proposals.student_id', '=', 'users.id')
        ->select(
            'club_proposals.id',
            'club_proposals.clubname',
            'club_proposals.clubdesc',
            'club_proposals.proposal_pdf',
            'club_proposals.status',
            'users.name as student_name',
            'club_proposals.created_at'
        )
        ->where('club_proposals.status', 'pending')
        ->orderBy('club_proposals.created_at', 'desc')
        ->paginate(5);

    return view('3_clubpage_module.clubrequest', compact('template', 'pendingProposals'));
}


public function store(Request $request)
{
    // Validate file
    $request->validate([
    'template_pdf' => 'required|mimes:pdf|max:5120|min:10',
    ]);

    // Check file validity
    if (!$request->file('template_pdf')->isValid()) {
        return back()->with('error', '❌ The uploaded file is invalid or corrupted.');
    }

    // Get existing template (there should only be one)
    $existingTemplate = \App\Models\ProposalTemplate::first();

    // If exists, delete old file and record
    if ($existingTemplate) {
        if (file_exists(storage_path('app/public/' . $existingTemplate->file_path))) {
            unlink(storage_path('app/public/' . $existingTemplate->file_path));
        }
        $existingTemplate->delete();
    }

    // Store new PDF
    $file = $request->file('template_pdf');
    $path = $file->store('proposal_templates', 'public'); // stores in /storage/app/public/proposal_templates

    // Save to database
    \App\Models\ProposalTemplate::create([
        'file_name' => $file->getClientOriginalName(),
        'file_path' => $path,
    ]);

    return back()->with('success', '✅ New proposal template uploaded and replaced successfully!');
}




/**
 * @return \Symfony\Component\HttpFoundation\StreamedResponse
 */
public function download()
{
    $template = ProposalTemplate::latest()->first();

    if (!$template || !Storage::disk('public')->exists($template->file_path)) {
        return back()->with('error', 'Template not found.');
    }

    return Storage::disk('public')->download($template->file_path, $template->file_name);
}
}

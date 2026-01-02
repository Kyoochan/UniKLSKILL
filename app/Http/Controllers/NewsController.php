<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Notification;
use App\Models\ProposalNews;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    // ===================== Normal News =====================

    // Show list of news
    public function index(Request $request)
    {
        // Build query
        $query = News::query()->latest();

        // 🔍 Apply search filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('news_name', 'like', '%'.$request->search.'%')
                    ->orWhere('news_description', 'like', '%'.$request->search.'%');
            });
        }

        // ✅ Use the filtered query (THIS FIXES SEARCH)
        $news = $query->paginate(5);

        // Latest 5 for sidebar
        $latestNews = News::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('4_newspage_module.newsindex', compact('news', 'latestNews'));
    }

    // Show manage news form
    public function create()
    {
        return view('4_newspage_module.managenews');
    }

    // Store new news item
    public function store(Request $request)
    {
        $validated = $request->validate([
            'news_name' => 'required|string|max:255',
            'news_description' => 'required|string',
            'image' => 'nullable|image|max:2048',

            // New fields
            'ghocs_element' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'dna_category' => 'nullable|string|max:255',
            'activity_date' => 'nullable|date',
            'activity_date_end' => 'nullable|date|after_or_equal:activity_date',
        ]);

        // ✅ If user uploads new image
        if ($request->hasFile('image')) {
            $validated['image'] =
                $request->file('image')->store('news_images', 'public');
        }
        // ✅ If no upload but image from proposal exists
        elseif ($request->proposal_image) {
            $validated['image'] = $request->proposal_image;
        }

        // ✅ Automatically set author name
        $validated['author'] = auth()->check()
            ? auth()->user()->name
            : 'Anonymous';

        News::create($validated);

        // Clear proposal autofill session
        session()->forget('from_proposal');
        session()->forget('proposal_data');

        return redirect()
            ->route('news.index')
            ->with('success', 'News added successfully!');
    }

    // View single news page
    public function show($id)
    {
        $news = News::findOrFail($id);

        return view('4_newspage_module.newsshow', compact('news'));
    }

    // ===================== Proposal News =====================

    public function proposalCreate()
    {
        $proposalNews = ProposalNews::latest()->paginate(10); // pass to view

        return view('4_newspage_module.proposalnews', compact('proposalNews'));
    }

    // Store new proposal news
    public function proposalStore(Request $request)
    {
        // Check if the user already has a pending proposal
        $pendingProposal = ProposalNews::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($pendingProposal) {
            return redirect()->route('proposalnews.create')
                ->with('error', 'You already have a pending proposal. Please wait for it to be approved.');
        }

        // Validate input
        $validated = $request->validate([
            'proposal_news_name' => 'required|string|max:255',
            'proposal_news_description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'proposal_pdf' => 'nullable|mimes:pdf|max:10240',
            'budget' => 'nullable|numeric|min:0',
            'additional_description' => 'nullable|string',
            'ghocs_element' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:255',
            'dna_category' => 'nullable|string|max:255',
            'activity_date' => 'nullable|date',
            'activity_date_end' => 'nullable|date|after_or_equal:activity_date',
        ]);

        // Assign user and default status
        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        // Handle file uploads before saving
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('proposal_news_images', 'public');
        }

        if ($request->hasFile('proposal_pdf')) {
            $validated['proposal_pdf'] = $request->file('proposal_pdf')->store('proposal_news_pdfs', 'public');
        }

        // Create the proposal
        ProposalNews::create($validated);

        // when proposal is submitted
        Notification::create([
            'user_id' => auth()->id(),
            'type' => 'proposal_submitted',
            'message' => "Your proposal '{$validated['proposal_news_name']}' has been submitted and is awaiting approval.",
        ]);

        // Redirect back with success
        return redirect()->route('proposalnews.create')
            ->with('success', 'Proposal news added successfully! Waiting for approval.');

    }

    // View single proposal news
    public function proposalShow($id)
    {
        $proposalNews = ProposalNews::findOrFail($id);

        return view('4_newspage_module.proposalnewsshow', compact('proposalNews'));
    }

    public function manage()
    {
        $proposalNews = ProposalNews::latest()->paginate(10);

        return view('4_newspage_module.manageproposalnews', compact('proposalNews'));
    }

    public function approve($id)
    {
        $proposal = ProposalNews::findOrFail($id);
        $proposal->status = 'approved';
        $proposal->save();

        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'proposal_approved',
            'message' => "Your proposal '{$proposal->proposal_news_name}' has been approved.",
        ]);

        // Store persistent session data
        session()->put('from_proposal', true);

        session()->put('proposal_data', [
            'news_name' => $proposal->proposal_news_name,
            'news_description' => $proposal->proposal_news_description,
            'image' => $proposal->image, // Must match your DB column
            'ghocs_element' => $proposal->ghocs_element,
            'level' => $proposal->level,
            'location' => $proposal->location,
            'dna_category' => $proposal->dna_category,
            'activity_date' => $proposal->activity_date,
            'activity_date_end' => $proposal->activity_date_end,
        ]);

        return redirect()->route('news.create');
    }

    public function reject($id)
    {
        $proposal = ProposalNews::findOrFail($id);
        $proposal->status = 'rejected';
        $proposal->save();

        Notification::create([
            'user_id' => $proposal->user_id,
            'type' => 'proposal_rejected',
            'message' => "Your proposal '{$proposal->proposal_news_name}' has been rejected.",
        ]);

        return back()->with('success', 'Proposal rejected.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);

        if ($news->image && \Storage::disk('public')->exists($news->image)) {
            \Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()
            ->route('news.index')
            ->with('success', 'News deleted successfully.');
    }
}

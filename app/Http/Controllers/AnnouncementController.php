<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubAnnouncement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function show($announcement_id)
    {
        $announcement = ClubAnnouncement::findOrFail($announcement_id);
        $club = Club::findOrFail($announcement->club_id);

        return view('3_clubpage_module.viewannouncement', compact('announcement', 'club'));
    }

    /**
     * Show the form to create a new announcement.
     */
    public function create($clubId)
    {
        $club = Club::findOrFail($clubId);

        return view('3_clubpage_module.createannouncement', compact('club'));
    }

    /**
     * Store the new announcement in the database.
     */
    public function store(Request $request, $clubId)
    {
        $club = Club::findOrFail($clubId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'attachment' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('attachment')) {
            $imagePath = $request->file('attachment')->store('announcements', 'public');
        }

        ClubAnnouncement::create([
            'club_id' => $club->id,
            'posted_by' => null, // No user tracking
            'title' => $validated['title'],
            'content' => $validated['content'],
            'attachment' => $imagePath,
        ]);

        return redirect()->route('club.show', $club->id)
            ->with('success', 'Announcement posted successfully!');
    }

    /**
     * Delete an announcement
     */
    public function destroy($club_id, $announcement_id)
    {
        $announcement = ClubAnnouncement::where('id', $announcement_id)
            ->where('club_id', $club_id)
            ->firstOrFail();

        // Delete attachment if exists
        if ($announcement->attachment) {
            \Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        return redirect()
            ->route('club.show', $club_id)
            ->with('success', 'Announcement deleted successfully!');
    }
}

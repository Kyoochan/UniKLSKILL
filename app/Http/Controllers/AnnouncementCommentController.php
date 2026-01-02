<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementComment;
use App\Models\PostedActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementCommentController extends Controller
{
    public function store(Request $request, $announcementId)
    {
        $validated = $request->validate([
            'comment' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcement_comments', 'public');
        }

        AnnouncementComment::create([
            'announcement_id' => $announcementId,
            'user_id' => Auth::id(),
            'comment' => $validated['comment'],
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function destroy($id)
    {
        $comment = AnnouncementComment::findOrFail($id);

        // Delete image if exists
        if ($comment->image && \Storage::disk('public')->exists($comment->image)) {
            \Storage::disk('public')->delete($comment->image);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}

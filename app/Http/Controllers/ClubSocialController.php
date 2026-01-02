<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Club;
use App\Models\ClubSocial;

class ClubSocialController extends Controller
{
    /**
     * Display a listing of the club's social links.
     */
    public function index($clubId)
    {
        $club = Club::findOrFail($clubId);
        $socials = $club->socials; // assuming relationship defined in Club model

        return view('3_clubpage_module.managesocial', compact('club', 'socials'));
    }

    /**
     * Store a newly created social link for the club.
     */
    public function store(Request $request, $clubId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url|max:500',
        ]);

        $club = Club::findOrFail($clubId);

        $club->socials()->create([
            'name' => $request->name,
            'link' => $request->link,
        ]);

        return redirect()->route('club.socials', $clubId)
                         ->with('success', 'Social link added successfully.');
    }

    /**
     * Remove the specified social link.
     */
    public function destroy($clubId, $socialId)
    {
        $club = Club::findOrFail($clubId);
        $social = $club->socials()->findOrFail($socialId);
        $social->delete();

        return redirect()->route('club.socials', $clubId)
                         ->with('success', 'Social link deleted successfully.');
    }
}

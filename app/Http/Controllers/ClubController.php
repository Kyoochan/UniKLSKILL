<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubAnnouncement;
use App\Models\Notification;
use App\Models\PostedActivity;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClubController extends Controller
{
    // Show all clubs
    public function index()
    {
        return view('3_clubpage_module.clubindex');
    }

    public function create($proposal_id = null)
    {
        if (Auth::user()->userRole !== 'admin') {
            abort(403, 'Unauthorized access - Admins only.');
        }

        $advisors = \App\Models\User::where('userRole', 'advisor')->get();
        $proposal = $proposal_id ? \App\Models\ClubProposal::find($proposal_id) : null;
        $student = null;
        if ($proposal) {
            $student = \App\Models\User::find($proposal->student_id);
        }

        return view('3_clubpage_module.createclub', compact('advisors', 'proposal', 'student'));
    }

    // Store new club
    public function store(Request $request)
    {
        if (Auth::user()->userRole !== 'admin') {
            abort(403, 'Unauthorized access - Admins only.');
        }

        $request->validate([
            'clubname' => 'required|string|max:255',
            'clubdesc' => 'required|string',
            'advisor_id' => 'nullable|exists:users,id',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
            'student_id' => 'nullable|exists:users,id',
        ]);

        $club = new Club;
        $club->clubname = $request->clubname;
        $club->clubdesc = $request->clubdesc;
        $club->advisor_id = $request->advisor_id;

        if ($request->hasFile('profile_picture')) {
            $club->profile_picture = $request->file('profile_picture')->store('clubs/profile', 'public');
        }
        if ($request->hasFile('banner_image')) {
            $club->banner_image = $request->file('banner_image')->store('clubs/banner', 'public');
        }

        $club->save();

        if ($club->advisor_id) {
            Notification::create([
                'user_id' => $club->advisor_id,
                'type' => 'advisor_assigned_new_club',
                'message' => "You have been assigned as the advisor for a new club: '{$club->clubname}'.",
            ]);
        }

        // Set  proposer as high committeeclub leader
        if ($request->filled('student_id')) {
            DB::table('club_members')->insert([
                'club_id' => $club->id,
                'user_id' => $request->student_id,
                'position' => 'high_committee',
                'role' => 'leader',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Notification::create([
                'user_id' => $request->student_id,
                'type' => 'leader_assigned',
                'message' => "Congratulations! You have been assigned as the leader of the new club '{$club->clubname}'.",
            ]);
        }

        return redirect()->route('club.index')
            ->with('success', 'New club created successfully!');
    }

    // Show a single club page
    public function show($id)
    {
        $club = Club::with('advisor')->findOrFail($id);

        // Fetch posted activities
        $postedActivities = PostedActivity::where('club_id', $club->id)
            ->orderBy('posted_at', 'desc')
            ->paginate(10);

        // Fetch club announcements
        $announcements = ClubAnnouncement::where('club_id', $club->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('3_clubpage_module.clubshow', compact('club', 'postedActivities', 'announcements'));
    }

    // Edit club
    public function edit($id)
    {
        $club = Club::with('members')->findOrFail($id);

        // Auth
        $memberRecord = $club->members->firstWhere('id', Auth::id());
        $isHighCommittee = $memberRecord && $memberRecord->pivot->position === 'high_committee';

        if (
            Auth::user()->userRole !== 'admin' &&
            ! (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) &&
            ! $isHighCommittee
        ) {
            abort(403, 'Unauthorized access - Only admin, advisor, or high committee can edit this club.');
        }

        $advisors = User::where('userRole', 'advisor')->get();

        return view('3_clubpage_module.clubedit', compact('club', 'advisors'));
    }

    // Update club
    public function update(Request $request, $id)
    {
        $club = Club::with('members')->findOrFail($id);

        // Auth
        $memberRecord = $club->members->firstWhere('id', Auth::id());
        $isHighCommittee = $memberRecord && $memberRecord->pivot->position === 'high_committee';

        if (
            Auth::user()->userRole !== 'admin' &&
            ! (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) &&
            ! $isHighCommittee
        ) {
            abort(403, 'Unauthorized access - Only admin, advisor, or high committee can update this club.');
        }

        $validationRules = [
            'clubdesc' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ];

        if (Auth::user()->userRole === 'admin') {
            $validationRules['clubname'] = 'required|string|max:255';
            $validationRules['advisor_id'] = 'nullable|exists:users,id';
        }

        $request->validate($validationRules);

        $oldAdvisorId = $club->advisor_id;

        // Preserve advisor_id for advisor or high_committee edits
        if (Auth::user()->userRole === 'advisor' || $isHighCommittee) {
            $request->merge(['advisor_id' => $club->advisor_id]);
        }

        if (Auth::user()->userRole === 'admin') {
            $club->clubname = $request->clubname;
            $club->advisor_id = $request->advisor_id;
        }

        $club->clubdesc = $request->clubdesc;

        if ($request->hasFile('profile_picture')) {
            $club->profile_picture = $request->file('profile_picture')->store('clubs/profile', 'public');
        }
        if ($request->hasFile('banner_image')) {
            $club->banner_image = $request->file('banner_image')->store('clubs/banner', 'public');
        }

        $club->save();

        $newAdvisorId = $club->advisor_id;
        if ($oldAdvisorId != $newAdvisorId && Auth::user()->userRole === 'admin') {
            if ($oldAdvisorId) {
                Notification::create([
                    'user_id' => $oldAdvisorId,
                    'type' => 'advisor_unassigned',
                    'message' => "You have been unassigned from the club '{$club->clubname}'.",
                ]);
            }

            if ($newAdvisorId) {
                Notification::create([
                    'user_id' => $newAdvisorId,
                    'type' => 'advisor_assigned',
                    'message' => "You have been assigned as the advisor for the club '{$club->clubname}'.",
                ]);
            }
        }

        return redirect()->route('club.show', $club->id)
            ->with('success', 'Club updated successfully!');
    }

    // Delete club
    public function destroy($id)
    {
        if (Auth::user()->userRole !== 'admin') {
            abort(403, 'Unauthorized access - Admins only.');
        }

        $club = Club::findOrFail($id);

        if ($club->advisor_id) {
            Notification::create([
                'user_id' => $club->advisor_id,
                'type' => 'club_deleted',
                'message' => "The club '{$club->clubname}' that you were assigned to has been disbanded and were removed by the admin.",
            ]);
        }

        $club->delete();

        return redirect()->route('club.index')->with('success', 'Club deleted successfully!');
    }

    // Show club members
    public function showMembers($id)
    {
        $club = Club::with('advisor')->findOrFail($id);

        // Auth
        $memberRecord = $club->members()->where('user_id', Auth::id())->first();
        $isHighCommittee = $memberRecord && $memberRecord->pivot->position === 'high_committee';

        if (
            Auth::user()->userRole !== 'admin' &&
            ! (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) &&
            ! $isHighCommittee
        ) {
            abort(403, 'Unauthorized access.');
        }

        $members = $club->members()->paginate(10, ['*'], 'members_page');

        $joinRequests = \App\Models\ClubJoinRequest::with('user')
            ->where('club_id', $club->id)
            ->paginate(10, ['*'], 'requests_page');

        return view('3_clubpage_module.clubmembers', compact('club', 'members', 'joinRequests'));
    }

    public function removeMember($clubId, $userId)
    {
        $club = Club::findOrFail($clubId);
        $memberRecord = $club->members()->where('user_id', Auth::id())->first();
        $isHighCommittee = $memberRecord && $memberRecord->pivot->position === 'high_committee';

        $club->members()->detach($userId);

        Notification::create([
            'user_id' => $userId,
            'type' => 'removed_from_club',
            'message' => "You have been removed from the club '{$club->clubname}'.",
        ]);

        return redirect()->back()->with('success', 'Member removed successfully.');
    }

    // promotion/demotion (high com <> member)
    public function toggleCommittee($clubId, $userId)
    {
        $club = Club::findOrFail($clubId);

        $member = $club->members()->where('user_id', $userId)->first();

        if (! $member) {
            return redirect()->back()->with('error', 'Member not found.');
        }

        $newPosition = $member->pivot->position === 'high_committee' ? 'member' : 'high_committee';

        $newRole = $newPosition === 'member' ? null : $member->pivot->role;

        $club->members()->updateExistingPivot($userId, [
            'position' => $newPosition,
            'role' => $newRole,
        ]);

        $action = $newPosition === 'high_committee' ? 'promoted to High Committee' : 'demoted from High Committee';
        Notification::create([
            'user_id' => $userId,
            'type' => 'committee_update',
            'message' => "You have been {$action} in '{$club->clubname}'.",
        ]);

        return redirect()->back()->with('success', 'Member updated successfully.');
    }

    // high com role assignment
    public function setRole($clubId, $userId, Request $request)
    {
        $club = Club::findOrFail($clubId);

        $authPivot = Auth::user()->clubMemberships()->where('club_id', $clubId)->first()?->pivot;
        $member = $club->members()->where('user_id', $userId)->first();

        if (! $member || $member->pivot->position !== 'high_committee') {
            return redirect()->back()->with('error', 'User must be high committee to assign a role.');
        }

        $isAdminOrAdvisor = Auth::user()->userRole === 'admin' || Auth::id() === $club->advisor_id;
        $isLeader = $authPivot?->position === 'high_committee' && $authPivot?->role === 'leader';
        $isSelf = Auth::id() === $userId;

        if (! ($isAdminOrAdvisor || ($isLeader && ! $isSelf))) {
            abort(403, 'Unauthorized to set this role.');
        }

        $role = $request->input('role');

        $club->members()->updateExistingPivot($userId, ['role' => $role]);

        Notification::create([
            'user_id' => $userId,
            'type' => 'role_assigned',
            'message' => "Your role in '{$club->clubname}' has been set to '{$role}'.",
        ]);

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    public function showActivity($id)
    {
        $club = Club::findOrFail($id);

        $postedActivities = PostedActivity::where('club_id', $club->id)
            ->orderBy('posted_at', 'desc')
            ->paginate(5);

        return view('3_clubpage_module.clubshow', compact('club', 'postedActivities'));
    }
}

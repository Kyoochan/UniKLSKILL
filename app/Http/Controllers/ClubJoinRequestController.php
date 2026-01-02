<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubJoinRequest;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClubJoinRequestController extends Controller
{
    public function store($id)
    {
        $club = Club::with('advisor')->findOrFail($id); // load advisor
        $userId = Auth::id();
        $user = Auth::user();

        // Check if user already a member
        if ($club->members()->where('user_id', $userId)->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this club.');
        }

        // Check if user already sent a pending request
        if (ClubJoinRequest::where('club_id', $id)->where('user_id', $userId)->where('status', 'pending')->exists()) {
            return redirect()->back()->with('error', 'You already have a pending join request.');
        }

        // Create join request
        $joinRequest = ClubJoinRequest::create([
            'club_id' => $id,
            'user_id' => $userId,
            'status' => 'pending',
        ]);

        // Notify all High Committee members of this club
        $highCommitteeMembers = $club->members()
            ->wherePivot('position', 'high_committee')
            ->get();

        foreach ($highCommitteeMembers as $hc) {
            Notification::create([
                'user_id' => $hc->id,
                'type' => 'join_request',
                'message' => "New join request from '{$joinRequest->user->name}' for your club '{$club->clubname}'.",
            ]);
        }

        // Notify the assigned advisor
        if ($club->advisor_id) {
            Notification::create([
                'user_id' => $club->advisor_id,
                'type' => 'join_request',
                'message' => "New join request from '{$joinRequest->user->name}' for your club '{$club->clubname}'.",
            ]);
        }

        return redirect()->back()->with('success', 'Join request sent successfully.');
    }

    public function approve($clubId, $requestId)
    {
        $club = Club::findOrFail($clubId);
        $request = ClubJoinRequest::findOrFail($requestId);

        // Only admin or assigned advisor
        if (Auth::user()->userRole !== 'admin' && Auth::id() !== $club->advisor_id) {
            abort(403);
        }

        // Add user to club members
        $club->members()->attach($request->user_id, ['position' => 'member']);

        // Notify the student
        Notification::create([
            'user_id' => $request->user_id,
            'type' => 'join_request_approved',
            'message' => "Your join request for '{$club->clubname}' has been approved.",
        ]);

        // Remove the join request after approval
        $request->delete();

        return redirect()->back()->with('success', 'Join request approved and removed.');
    }

    public function approveAllJoinRequests(Request $request, $clubId)
    {
        $club = Club::findOrFail($clubId);
        $user = Auth::user();

        // Check if user is admin, advisor, or high_committee member of this club
        $isHighCommittee = $user->clubMemberships()
            ->where('club_id', $club->id)
            ->wherePivot('position', 'high_committee')
            ->exists();

        if ($user->userRole !== 'admin' && $club->advisor_id !== $user->id && ! $isHighCommittee) {
            abort(403);
        }

        $requestIds = $request->input('requests', []);

        foreach ($requestIds as $requestId) {
            $joinRequest = \App\Models\ClubJoinRequest::find($requestId);
            if ($joinRequest) {
                $club->members()->attach($joinRequest->user_id, ['position' => 'member']);

                Notification::create([
                    'user_id' => $joinRequest->user_id,
                    'type' => 'join_request_approved',
                    'message' => "Your join request for '{$club->clubname}' has been approved.",
                ]);

                $joinRequest->delete();
            }
        }

        return redirect()->back()->with('success', 'Selected join requests approved.');
    }

    public function rejectAllJoinRequests(Request $request, $clubId)
    {
        $club = Club::findOrFail($clubId);
        $user = Auth::user();

        // Check if user is admin, advisor, or high_committee member of this club
        $isHighCommittee = $user->clubMemberships()
            ->where('club_id', $club->id)
            ->wherePivot('position', 'high_committee')
            ->exists();

        if ($user->userRole !== 'admin' && $club->advisor_id !== $user->id && ! $isHighCommittee) {
            abort(403);
        }

        $requestIds = $request->input('requests', []);

        foreach ($requestIds as $requestId) {
            $joinRequest = \App\Models\ClubJoinRequest::find($requestId);
            if ($joinRequest) {
                $joinRequest->update(['status' => 'rejected']);

                Notification::create([
                    'user_id' => $joinRequest->user_id,
                    'type' => 'join_request_rejected',
                    'message' => "Your join request for '{$club->clubname}' has been rejected.",
                ]);

                $joinRequest->delete();
            }
        }

        return redirect()->back()->with('success', 'Selected join requests rejected.');
    }
}

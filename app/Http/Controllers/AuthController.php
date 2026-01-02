<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Club;
use App\Models\Notification;


class AuthController extends Controller
{
    /**
     * Show Register Page
     */
    public function userRegister()
    {
        return view('1_login_module.register'); // Create resources/views/auth/register.blade.php
    }

    /**
     * Handle Register Form
     */
    public function storeRegister(Request $request)
    {
        // Validate input
        $request->validate([
            'student_id' => 'required|string|unique:users,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'userRole' => 'student',
        ]);

        // Create user
        User::create([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.show')->with('success', 'Registration successful! Please log in.');
    }

    /**
     * Show Login Page
     */
    public function userLogin()
    {
        return view('1_login_module.login'); // Create resources/views/auth/login.blade.php
    }

    /**
     * Handle Login
     */
    public function storeLogin(Request $request)
    {
        // Validate input
        $request->validate([
            'login' => 'required', // can be student_id or email
            'password' => 'required|min:6',
        ]);

        // Determine if login is by student_id or email
        $fieldType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'student_id';

        // Attempt login
        if (Auth::attempt([$fieldType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->withErrors(['login' => 'Invalid credentials.']);
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.show');
    }

    public function storeStaffAccount(Request $request)
{
    if (Auth::user()->userRole !== 'admin') {
        abort(403, 'Unauthorized access - Admins only.');
    }

    $request->validate([
        'staff_id' => 'required|string|max:255|unique:users,student_id',
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed|min:6',
        'userRole' => 'required|in:admin,advisor,secretary',
    ]);

    \App\Models\User::create([
        'student_id' => $request->staff_id,
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'userRole' => $request->userRole,
    ]);

    return redirect()->route('staffaccount')->with('success', 'Staff account created successfully!');
}

public function showStaffAccount()
{
    if (Auth::user()->userRole !== 'admin') {
        abort(403, 'Unauthorized access - Admins only.');
    }

    // Fetch all staff
    $staff = User::with('club')->whereIn('userRole', ['admin', 'advisor', 'secretary'])->get();

    // Fetch clubs that have no advisor assigned
    $availableClubs = Club::whereNull('advisor_id')->get();

    return view('1_login_module.staffaccount', compact('staff', 'availableClubs'));
}

// Assign advisor to a club
public function assignAdvisor(Request $request, $id)
{
    $request->validate([
        'club_id' => 'required|exists:clubs,id',
    ]);

    $advisor = User::findOrFail($id);

    if ($advisor->userRole !== 'advisor') {
        return back()->with('error', 'This user is not an advisor.');
    }

    // Ensure the advisor isn't already assigned
    $alreadyAssigned = Club::where('advisor_id', $advisor->id)->first();
    if ($alreadyAssigned) {
        return back()->with('error', 'This advisor is already assigned to a club.');
    }

    // Assign advisor
    $club = Club::findOrFail($request->club_id);
    $club->advisor_id = $advisor->id;
    $club->save();

    // ✅ Send notification to the advisor
    Notification::create([
        'user_id' => $advisor->id,
        'type' => 'advisor_assigned',
        'message' => "You have been assigned as the advisor for the club '{$club->clubname}'.",
    ]);

    return back()->with('success', 'Advisor assigned to club successfully.');
}

// Unassign advisor
public function unassignAdvisor($id)
{
    $advisor = User::findOrFail($id);

    if ($advisor->userRole !== 'advisor') {
        return back()->with('error', 'This user is not an advisor.');
    }

    $club = Club::where('advisor_id', $advisor->id)->first();

    if ($club) {
        $club->advisor_id = null;
        $club->save();

        // ✅ Send notification to the advisor
        Notification::create([
            'user_id' => $advisor->id,
            'type' => 'advisor_unassigned',
            'message' => "You have been unassigned from the club '{$club->clubname}'.",
        ]);
    }

    return back()->with('success', 'Advisor unassigned successfully.');
}
}

@extends('layoutStyle.styling')
{{-- High Com/Club Advisor manage students request to join club,promote and demote, role of High Com --}}
@section('content')
    <div class="container mx-auto p-4">

        <div class="w-10/12 bg-white p-6 rounded-lg shadow-md flex flex-col gap-2 mx-auto my-5">

            <!-- Alpine.js Tabs Example -->
            <div x-data="{ tab: 1 }" class="max-w-4xl mx-auto mt-8">

                <!-- Tab Buttons -->
                <div class="flex border-b border-gray-300 mb-4">
                    <button
                        :class="tab === 1 ? 'bg-orange-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-orange-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                        @click="tab = 1">
                        Manage Member
                    </button>
                    <button
                        :class="tab === 2 ? 'bg-orange-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-orange-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                        @click="tab = 2">
                        Manage Join Request
                    </button>
                </div>

                <!-- Tab Content -->
                <div class="bg-white p-6 rounded shadow">
                    <!-- Container for Tab 1 -->
                    <div x-show="tab === 1" x-transition>
                        {{-- Club Advisor --}}
                        <h2 class="text-2xl font-bold mb-4 text-center">{{ $club->clubname }} Advisor</h2>
                        <div class="bg-gray-50 border border-gray-300 rounded-lg p-5 mb-5 shadow-sm">
                            <div class="space-y-2 text-gray-800">
                                <div class="ml-1 space-y-1">
                                    <p><strong>Advisor Name:</strong>
                                        <span id="current-advisor"
                                            class="font-medium text-gray-900">{{ $club->advisor?->name ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong>Advisor Email:</strong>
                                        <span class="text-gray-600 text-sm">{{ $club->advisor?->email ?? 'N/A' }}</span>
                                    </p>
                                    <p><strong>Advisor Contact Number:</strong>
                                        <span
                                            class="text-gray-600 text-sm">{{ $club->advisor?->phone_number ?? 'N/A' }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Club Members --}}
                        <h2 class="text-2xl font-bold mb-4 text-center">{{ $club->clubname }} Members</h2>

                        <table class="w-full blue border-blue-200">
                            <thead class="bg-blue-800 text-center text-white">
                                <tr>
                                    <th class="px-4 py-2 border">Student ID</th>
                                    <th class="px-4 py-2 border">Name</th>
                                    <th class="px-4 py-2 border">Status</th>
                                    <th class="px-4 py-2 border">Role</th>
                                    <th class="px-4 py-2 border">Phone Number</th>
                                    <th class="px-4 py-2 border">Joined At</th>
                                    <th class="px-4 py-2 border">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($members as $member)
                                    @php
                                        $memberPivot = $member->pivot;
                                        $authPivot = Auth::user()
                                            ->clubMemberships()
                                            ->where('club_id', $club->id)
                                            ->first()?->pivot;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-2 border">{{ $member->student_id }}</td>
                                        <td class="px-4 py-2 border">{{ $member->name }}</td>
                                        <td class="px-4 py-2 border">{{ ucfirst($memberPivot?->position ?? 'N/A') }}</td>
                                        <td class="px-4 py-2 border">
                                            {{ $memberPivot?->role ?? '-' }}

                                            {{-- Show dropdown only if current user is club advisor,
                                 OR a high_committee leader editing someone else --}}
                                            @php
                                                // Get all high_committee members of this club
                                                $highCommitteeMembers = $club->members->where(
                                                    'pivot.position',
                                                    'high_committee',
                                                );

                                                // Check if there is already a leader other than this member
                                                $leaderExists = $highCommitteeMembers
                                                    ->where('pivot.role', 'leader')
                                                    ->where('id', '!=', $member->id)
                                                    ->isNotEmpty();
                                            @endphp

                                            @if (Auth::id() === $club->advisor_id ||
                                                    ($authPivot?->position === 'high_committee' && $authPivot?->role === 'leader' && Auth::id() !== $member->id))
                                                @if ($memberPivot?->position === 'high_committee')
                                                    <form
                                                        action="{{ route('club.member.setRole', [$club->id, $member->id]) }}"
                                                        method="POST" class="mt-1">
                                                        @csrf
                                                        <select name="role" onchange="this.form.submit()"
                                                            class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                                                            <option value="">Select Role</option>
                                                            <option value="leader"
                                                                {{ $memberPivot?->role === 'leader' ? 'selected' : '' }}
                                                                {{ $leaderExists ? 'disabled' : '' }}>Leader</option>
                                                            <option value="vice_leader"
                                                                {{ $memberPivot?->role === 'vice_leader' ? 'selected' : '' }}>
                                                                Vice
                                                                Leader</option>
                                                            <option value="treasurer"
                                                                {{ $memberPivot?->role === 'treasurer' ? 'selected' : '' }}>
                                                                Treasurer
                                                            </option>
                                                            <option value="secretary"
                                                                {{ $memberPivot?->role === 'secretary' ? 'selected' : '' }}>
                                                                Secretary
                                                            </option>
                                                            <option value="event_coordinator"
                                                                {{ $memberPivot?->role === 'event_coordinator' ? 'selected' : '' }}>
                                                                Event Coordinator</option>
                                                            <option value="multimedia"
                                                                {{ $memberPivot?->role === 'multimedia' ? 'selected' : '' }}>
                                                                Multimedia
                                                            </option>
                                                            <option value="sponsorship"
                                                                {{ $memberPivot?->role === 'sponsorship' ? 'selected' : '' }}>
                                                                Sponsorship</option>
                                                            <option value="logistic"
                                                                {{ $memberPivot?->role === 'logistic' ? 'selected' : '' }}>
                                                                Logistic
                                                            </option>
                                                            <option value="public_relations"
                                                                {{ $memberPivot?->role === 'public_relations' ? 'selected' : '' }}>
                                                                Public Relations</option>
                                                            <option value="membership"
                                                                {{ $memberPivot?->role === 'membership' ? 'selected' : '' }}>
                                                                Membership
                                                            </option>
                                                        </select>
                                                    </form>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-4 py-2 border">{{ $member->phone_number ?? 'N/A' }}</td>
                                        <td class="px-4 py-2 border">
                                            @if ($memberPivot?->created_at)
                                                @php
                                                    $joinedAt = $memberPivot->created_at;
                                                    $monthsExact = $joinedAt->floatDiffInMonths(now()); // exact months as float
                                                    $monthsRounded = round($monthsExact, 2); // keep 2 decimals

                                                    // Convert to years + remaining months
                                                    $years = floor($monthsRounded / 12);
                                                    $remainingMonths = round($monthsRounded - $years * 12, 2); // remaining months with decimals
                                                @endphp

                                                {{ $joinedAt->format('d M Y') }}
                                                <p>
                                                (@if ($years > 0)
                                                    {{ $years }} year{{ $years > 1 ? 's' : '' }}
                                                @endif
                                                @if ($remainingMonths > 0)
                                                    {{ $remainingMonths }} month{{ $remainingMonths != 1 ? 's' : '' }}
                                                @endif)
                                                </p>
                                            @else
                                                N/A
                                            @endif
                                        </td>


                                        <td class="px-4 py-2 border gap-2 text-center">
                                            @php
                                                $authPivot = Auth::user()
                                                    ->clubMemberships()
                                                    ->where('club_id', $club->id)
                                                    ->first()?->pivot;
                                                $canModify =
                                                    Auth::user()->userRole === 'admin' ||
                                                    Auth::id() === $club->advisor_id;
                                                $isHighCommitteeLeader =
                                                    $authPivot?->position === 'high_committee' &&
                                                    $authPivot?->role === 'leader';
                                                $isHighCommittee = $authPivot?->position === 'high_committee';
                                                $isSelf = Auth::id() === $member->id;
                                            @endphp

                                            {{-- Promote to High Committee --}}
                                            @if (($canModify || $isHighCommitteeLeader) && $memberPivot?->position !== 'high_committee')
                                                <form
                                                    action="{{ route('club.member.toggleCommittee', [$club->id, $member->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2 mb-4 py-1 rounded text-white bg-blue-600 hover:bg-blue-700">
                                                        Promote
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Demote High Committee --}}
                                            @if ($memberPivot?->position === 'high_committee' && ($canModify || $isHighCommitteeLeader || $isSelf))
                                                <form
                                                    action="{{ route('club.member.toggleCommittee', [$club->id, $member->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="px-2 py-1 mb-2 rounded text-white bg-yellow-500 hover:bg-yellow-600">
                                                        Demote
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Remove Member --}}
                                            @if (
                                                $canModify ||
                                                    ($isHighCommitteeLeader && $memberPivot?->position !== 'high_committee') ||
                                                    ($isHighCommittee && $memberPivot?->position !== 'high_committee'))
                                                <form action="{{ route('club.member.remove', [$club->id, $member->id]) }}"
                                                    method="POST" onsubmit="return confirm('Remove this member?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Remove
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-2 text-center border">No members yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-4 text-center text-sm text-gray-600">
                            Showing page {{ $members->currentPage() }} of {{ $members->lastPage() }}
                        </div>
                        {{-- Back Button --}}
                        <div class="flex justify-left mt-8 gap-4">
                            <a href="{{ route('club.show', $club->id) }}"
                                class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                                Back to {{ $club->clubname }} Page
                            </a>
                        </div>
                    </div>

                    <!-- Container for Tab 2 -->
                    <div x-show="tab === 2" x-transition>
                        <div class="flex justify-center mt-2">
                            {!! $members->appends(request()->except('members_page'))->links() !!}
                        </div>
                        {{-- Join Requests Section --}}
                        <h2 class="text-2xl  font-bold my-4 text-center">{{ $club->clubname }} Join Requests</h2>
                        <form method="POST" id="bulkJoinRequestForm">
                            @csrf
                            <table class="min-w-full border border-gray-200">
                                <thead class="bg-blue-800 text-center text-white">
                                    <tr>
                                        <th class="px-4 py-2 border">Student ID</th>
                                        <th class="px-4 py-2 border">Name</th>
                                        <th class="px-4 py-2 border">Phone Number</th>
                                        <th class="px-4 py-2 border">Status</th>
                                        <th class="px-4 py-2 border">Requested At</th>
                                        <th class="px-4 py-2 flex justify-center">
                                            <div class="flex items-center gap-2 relative group">
                                                <span
                                                    class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer">?</span>
                                                <div
                                                    class="absolute left-full ml-2 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                                    Select this checkbox to select all student's club join requests for bulk
                                                    join
                                                    approval actions.
                                                </div>
                                                <label class="flex items-center gap-1 cursor-pointer">
                                                    Check All
                                                    <input type="checkbox" id="selectAll" class="form-checkbox">
                                                </label>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($joinRequests as $request)
                                        <tr>
                                            <td class="px-4 py-2 border">{{ $request->user->student_id }}</td>
                                            <td class="px-4 py-2 border">{{ $request->user->name }}</td>
                                            <td class="px-4 py-2 border">{{ $request->user->phone_number }}</td>
                                            <td class="px-4 py-2 border">{{ ucfirst($request->status) }}</td>
                                            <td class="px-4 py-2 border">{{ $request->created_at->format('d M Y') }}</td>
                                            <td class="px-4 py-2 flex justify-center">
                                                <input type="checkbox" name="requests[]" value="{{ $request->id }}">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-4 py-2 text-center border">No join requests yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="mt-4 text-center text-sm text-gray-600">
                                Showing page {{ $joinRequests->currentPage() }} of {{ $joinRequests->lastPage() }}
                            </div>

                            <div class="flex justify-center mt-2">
                                {!! $joinRequests->appends(request()->except('requests_page'))->links() !!}
                            </div>


                            <div class="flex justify-center mt-2">
                                {!! $members->appends(request()->except('members_page'))->links() !!}
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button id="approveSelected"
                                    formaction="{{ route('club.joinrequest.approveAll', $club->id) }}" type="submit"
                                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    Approve Selected
                                </button>
                                <button id="rejectSelected"
                                    formaction="{{ route('club.joinrequest.rejectAll', $club->id) }}" type="submit"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                                    disabled>
                                    Reject Selected
                                </button>
                            </div>

                            <script>
                                const selectAllCheckbox = document.getElementById('selectAll');
                                const requestCheckboxes = document.querySelectorAll('input[name="requests[]"]');
                                const approveBtn = document.getElementById('approveSelected');
                                const rejectBtn = document.getElementById('rejectSelected');

                                function toggleActionButtons() {
                                    const anyChecked = Array.from(requestCheckboxes).some(cb => cb.checked);
                                    approveBtn.disabled = !anyChecked;
                                    rejectBtn.disabled = !anyChecked;
                                }

                                selectAllCheckbox.addEventListener('change', function() {
                                    requestCheckboxes.forEach(cb => cb.checked = this.checked);
                                    toggleActionButtons();
                                });

                                requestCheckboxes.forEach(cb => cb.addEventListener('change', toggleActionButtons));
                            </script>

                            {{-- Back Button --}}
                            <div class="flex justify-left mt-8 gap-4">
                                <a href="{{ route('club.show', $club->id) }}"
                                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                                    Back to {{ $club->clubname }} Page
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <!-- Make sure Alpine.js is included -->
            <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

        </div>
    </div>
@endsection

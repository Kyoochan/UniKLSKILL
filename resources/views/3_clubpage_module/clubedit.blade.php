@extends('layoutStyle.styling')
{{-- Admin/High Com/Club Advisor of the clubs edit page via this blade --}}
@section('content')
    <div class="flex justify-center">
        <div class="w-10/12 bg-white p-6 rounded-lg shadow my-10">
            <h2 class="text-4xl font-bold mb-6 mt-4 text-center border-b py-2">Edit {{ $club->clubname }}</h2>

            <form action="{{ route('club.update', $club->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Club Name --}}
                @auth
                    @if (Auth::user()->userRole === 'admin')
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Club Name</label>
                            <input type="text" name="clubname" value="{{ $club->clubname }}" placeholder="Insert club name..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                        </div>
                    @endif
                @endauth

                {{-- Description --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="clubdesc" rows="4" placeholder="Insert club description..."
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>{{ $club->clubdesc }}</textarea>
                </div>

                {{-- Profile Picture --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Profile Picture</label>
                    @if ($club->profile_picture)
                        <img src="{{ asset('storage/' . $club->profile_picture) }}" class="h-20 mb-2">
                    @endif
                    <input type="file" name="profile_picture" class="w-full border p-2 rounded-lg">
                </div>

                {{-- Banner Image --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Banner Image</label>
                    @if ($club->banner_image)
                        <img src="{{ asset('storage/' . $club->banner_image) }}" class="h-20 mb-2">
                    @endif
                    <input type="file" name="banner_image" class="w-full border p-2 rounded-lg">
                </div>


                {{-- Advisor Section --}}
                <div class="mb-6">
                    {{-- Current Advisor Info --}}
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-5 mb-5 shadow-sm">
                        @if ($club->advisor)
                            <div class="space-y-2 text-gray-800">
                                <h4 class="text-lg font-semibold text-blue-800 flex items-center gap-2">
                                    <span class="text-gray-700">Current Assigned Advisor</span>
                                </h4>

                                <div class="ml-1 space-y-1">
                                    <p><strong>Advisor Name:</strong>
                                        <span id="current-advisor"
                                            class="font-medium text-gray-900">{{ $club->advisor->name }}</span>
                                    </p>
                                    <p><strong>Advisor Email:</strong>
                                        <span class="text-gray-600 text-sm">{{ $club->advisor->email }}</span>
                                    </p>
                                </div>
                                @auth
                                    @if (Auth::user()->userRole === 'admin')
                                        <div class="pt-3">
                                            <button type="button" id="unassignCurrentBtn"
                                                class="px-4 py-2 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition-all shadow-sm">
                                                Unassign Current Advisor
                                            </button>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p id="current-advisor" class="text-gray-500 italic">
                                    No advisor currently assigned to this club.
                                </p>
                            </div>
                        @endif
                    </div>

                    @auth
                        @if (Auth::user()->userRole === 'admin')
                            <div class="flex items-center mb-4 space-x-2">
                                <h3 class="text-lg font-semibold text-gray-800">Assign Club Advisor</h3>

                                {{-- Tooltip --}}
                                <div class="relative group">
                                    <span
                                        class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                        title="Information">?</span>

                                    <div
                                        class="absolute left-6 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                        Select one advisor to assign to this club. Each advisor can only be assigned to one
                                        club
                                        at
                                        a time.
                                    </div>
                                </div>
                            </div>


                            {{-- Advisor Selection Table --}}
                            <input type="hidden" name="advisor_id" id="selectedAdvisor" value="{{ $club->advisor_id }}">

                            {{-- Advisor Table --}}
                            <table class="min-w-full border border-gray-300 mb-4">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Advisor Name</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                                        <th class="border border-gray-300 px-4 py-2 text-left">Current Club Assigned To</th>
                                        <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($advisors as $advisor)
                                        @php
                                            $assignedClub = \App\Models\Club::where(
                                                'advisor_id',
                                                $advisor->id,
                                            )->first();
                                            $isSelected = $club->advisor_id == $advisor->id;
                                        @endphp
                                        <tr class="hover:bg-gray-50">
                                            <td class="border border-gray-300 px-4 py-2">{{ $advisor->name }}</td>
                                            <td class="border border-gray-300 px-4 py-2">{{ $advisor->email }}</td>
                                            <td class="border border-gray-300 px-4 py-2">
                                                @if ($assignedClub)
                                                    <span class="text-gray-700">{{ $assignedClub->clubname }}</span>
                                                @else
                                                    <span class="text-gray-500 italic">Unassigned to any club</span>
                                                @endif
                                            </td>
                                            <td class="border border-gray-300 px-4 py-2 text-center">
                                                <div class="flex justify-center items-center space-x-2">
                                                    {{-- Hidden Radio --}}
                                                    <input type="radio" name="advisor_select"
                                                        id="advisor_{{ $advisor->id }}" value="{{ $advisor->id }}"
                                                        class="hidden advisor-radio" data-advisor-name="{{ $advisor->name }}"
                                                        {{ $isSelected ? 'checked' : '' }}>

                                                    {{-- Select/Selected Button --}}
                                                    <label for="advisor_{{ $advisor->id }}"
                                                        class="select-btn px-3 py-1 rounded text-white transition
                                            {{ $assignedClub
                                                ? ($assignedClub->id == $club->id
                                                    ? 'bg-gray-600 cursor-not-allowed opacity-80'
                                                    : 'bg-gray-400 cursor-not-allowed opacity-60')
                                                : 'bg-blue-600 hover:bg-blue-700 cursor-pointer' }}"
                                                        data-advisor-id="{{ $advisor->id }}"
                                                        data-assigned-club="{{ $assignedClub->id ?? '' }}">
                                                        {{ $assignedClub ? ($assignedClub->id == $club->id ? 'Currently assigned to this club' : 'Assigned') : 'Select' }}
                                                    </label>

                                                    {{-- Redirect to assigned club --}}
                                                    @if ($assignedClub && $assignedClub->id != $club->id)
                                                        <a href="{{ route('club.edit', $assignedClub->id) }}"
                                                            class="ml-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition"
                                                            title="Go to {{ $assignedClub->clubname }} to unassign advisor">
                                                            Edit {{ $assignedClub->clubname }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                @endauth
                {{-- Action Buttons --}}
                <div class="flex justify-left mt-8 gap-4">
                    <a href="{{ route('club.index', $club->id) }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                        Back to Club Main Page
                    </a>

                    <a href="{{ route('club.show', $club->id) }}"
                        class="px-4 py-2 bg-orange-400 text-white rounded-lg hover:bg-orange-500 transition">
                        Back to {{ $club->clubname }} Page
                    </a>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JavaScript Section --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hiddenInput = document.getElementById('selectedAdvisor');
            const currentAdvisor = document.getElementById('current-advisor');
            const unassignBtn = document.getElementById('unassignCurrentBtn');

            const originalAdvisorId = hiddenInput.value;
            const originalAdvisorName = currentAdvisor.textContent.trim();

            // Select Advisor Logic
            document.querySelectorAll('.select-btn').forEach(btn => {
                btn.addEventListener('click', e => {
                    if (btn.classList.contains('cursor-not-allowed')) {
                        e.preventDefault();
                        return;
                    }

                    // Reset all buttons
                    document.querySelectorAll('.select-btn').forEach(b => {
                        if (!b.classList.contains('cursor-not-allowed')) {
                            b.textContent = 'Select';
                            b.classList.remove('bg-green-600', 'hover:bg-green-700');
                            b.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        }
                    });

                    // Highlight selected button
                    btn.textContent = 'Selected';
                    btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    btn.classList.add('bg-green-600', 'hover:bg-green-700');

                    const radio = btn.previousElementSibling;
                    hiddenInput.value = radio.value;
                    currentAdvisor.innerHTML =
                        `${radio.dataset.advisorName} <span class="text-gray-500 text-sm">(Pending Save)</span>`;

                    // Reset unassign button state
                    unassignBtn.disabled = false;
                    unassignBtn.textContent = 'Unassign Current Advisor';
                    unassignBtn.classList.remove('bg-gray-400', 'cursor-not-allowed', 'opacity-70');
                    unassignBtn.classList.add('bg-red-500', 'hover:bg-red-600');
                });
            });

            // Unassign Advisor Logic
            if (unassignBtn) {
                unassignBtn.addEventListener('click', () => {
                    const isUnassigning = unassignBtn.dataset.state === 'unassigning';

                    if (!isUnassigning) {
                        if (!confirm(
                                "Are you sure you want to unassign the current advisor from this club?"))
                            return;

                        hiddenInput.value = '';

                        unassignBtn.textContent = 'Cancel Unassignment';
                        unassignBtn.classList.remove('bg-red-500', 'hover:bg-red-600');
                        unassignBtn.classList.add('bg-yellow-500', 'hover:bg-yellow-600');
                        unassignBtn.dataset.state = 'unassigning';
                    } else {
                        hiddenInput.value = originalAdvisorId;
                        currentAdvisor.textContent = originalAdvisorName;

                        unassignBtn.textContent = 'Unassign Current Advisor';
                        unassignBtn.classList.remove('bg-yellow-500', 'hover:bg-yellow-600');
                        unassignBtn.classList.add('bg-red-500', 'hover:bg-red-600');
                        unassignBtn.dataset.state = '';
                    }
                });
            }
        });
    </script>
@endsection

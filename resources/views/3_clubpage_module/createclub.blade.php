@extends('layoutStyle.styling')
{{-- Admin create club with/without proposal --}}
@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg shadow my-10 px-23">

            <h2 class="text-2xl font-bold mb-6 border-b text-center py-2">Create New Club</h2>
            <form action="{{ route('club.store') }}" method="POST" enctype="multipart/form-data" id="createClubForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Club Name</label>
                    <input type="text" name="clubname" value="{{ old('clubname', $proposal->clubname ?? '') }}"
                        placeholder="Insert club's name..."
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="clubdesc" rows="4" placeholder="Insert club's description..."
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>{{ old('clubdesc', $proposal->clubdesc ?? '') }}</textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-2">Profile Picture</label>
                    <input type="file" name="profile_picture" accept="image/*"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                </div>
                <div class="mb-8">
                    <label class="block text-gray-700 font-medium mb-2">Banner Image</label>
                    <input type="file" name="banner_image" accept="image/*" class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                </div>

                @if (isset($student))
                    <div class="flex items-center mb-4 space-x-2">

                        <h3 class="text-lg font-semibold text-gray-800">Club Proposed By</h3>
                        <div class="relative group">
                            <span
                                class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                title="Information">?</span>
                            <div
                                class="absolute left-6 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                Student who proposed this club will be automatically appointed as the club leader.
                            </div>
                        </div>
                    </div>
                    <div class="border rounded-lg bg-gray-50 p-4">
                        <p><strong>Student Name:</strong> {{ $student->name }}</p>
                        <p><strong>Student ID:</strong> {{ $student->id }}</p>
                        <p><strong>Email:</strong> {{ $student->email }}</p>
                    </div>
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                @endif

                {{-- Advisor Section --}}
                <div class="mb-6">
                    <div class="flex items-center mb-4 space-x-2">
                        <h3 class="text-lg font-semibold text-gray-800">Assign Club Advisor</h3>

                        {{-- Tooltip --}}
                        <div class="relative group">
                            <span
                                class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                title="Information">?</span>

                            <div
                                class="absolute left-6 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                Select one advisor to assign to this club. Advisors that is already assigned to another club
                                cannot be selected during new club creation.
                            </div>
                        </div>
                    </div>

                    {{-- Advisor Table --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border">Advisor Name</th>
                                    <th class="py-2 px-4 border">Email</th>
                                    <th class="py-2 px-4 border">Current Club Assigned To</th>
                                    <th class="py-2 px-4 border text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($advisors as $index => $advisor)
                                    @php
                                        $assignedClub = \App\Models\Club::where('advisor_id', $advisor->id)->first();
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-2 px-4 border">{{ $advisor->name }}</td>
                                        <td class="py-2 px-4 border">{{ $advisor->email }}</td>
                                        <td class="py-2 px-4 border">
                                            @if ($assignedClub)
                                                <span
                                                    class="text-red-600 font-semibold">{{ $assignedClub->clubname }}</span>
                                            @else
                                                <span class="text-green-600 font-semibold">Available</span>
                                            @endif
                                        </td>
                                        <td class="py-2 px-4 border text-center">
                                            @if ($assignedClub)
                                                <button type="button"
                                                    class="px-3 py-1 bg-gray-300 text-gray-600 rounded cursor-not-allowed"
                                                    disabled>
                                                    Already Assigned to a Club
                                                </button>
                                            @else
                                                <button type="button"
                                                    class="assign-btn px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
                                                    data-advisor-id="{{ $advisor->id }}">
                                                    Assign
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Hidden advisor_id field --}}
                <input type="hidden" name="advisor_id" id="selectedAdvisor">

                {{-- Action Buttons --}}
                <div class="flex justify-left mt-8 gap-4">
                    <a href="{{ route('club.index') }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                        Back to Club Main Page
                    </a>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                        Create Club
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- JS for advisor selection --}}
    <script>
        document.querySelectorAll('.assign-btn').forEach(button => {
            button.addEventListener('click', function() {
                const advisorId = this.dataset.advisorId;
                document.getElementById('selectedAdvisor').value = advisorId;

                // Reset all buttons
                document.querySelectorAll('.assign-btn').forEach(btn => {
                    btn.classList.remove('bg-green-600', 'text-white');
                    btn.classList.add('bg-blue-600');
                    btn.textContent = 'Assign';
                });

                // Highlight selected
                this.classList.remove('bg-blue-600');
                this.classList.add('bg-green-600', 'text-white');
                this.textContent = 'Selected';
            });
        });
    </script>
@endsection

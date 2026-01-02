@extends('layoutStyle.styling')
{{-- club advisor check the proposed club activity details --}}
@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 mb-10">

        <h2 class="text-2xl font-bold mb-6 text-black-700">View Proposed Activity</h2>

        {{-- BACK BUTTON --}}
        <div class="space-y-4">
            <div>
                <label class="font-semibold text-gray-700">Activity Title</label>
                <p class="p-2 bg-gray-100 border rounded">{{ $proposal->activity_title }}</p>
            </div>

            <div>
                <p class="font-semibold text-gray-700 mb-2">Poster Image</p>
                @if ($proposal->poster_image)
                    <img src="{{ asset('storage/' . $proposal->poster_image) }}" alt="Poster Image"
                        class="w-full max-w-md h-auto border rounded">
                @else
                    <p class="text-gray-500">No poster image provided.</p>
                @endif
            </div>

            <div>
                <label class="font-semibold text-gray-700">Description</label>
                <p class="p-2 bg-gray-100 border rounded">{{ $proposal->activity_description }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Activity Date</label>
                <p class="p-2 bg-gray-100 border rounded">
                    {{ $proposal->activity_date }}
                    @if ($proposal->activity_date_end)
                        - {{ $proposal->activity_date_end }}
                    @endif
                </p>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="font-semibold text-gray-700">Level</label>
                    <p class="p-2 bg-gray-100 border rounded">{{ $proposal->level }}</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">DNA Category</label>
                    <p class="p-2 bg-gray-100 border rounded">{{ $proposal->dna_category }}</p>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">GHOCS Element</label>
                    <p class="p-2 bg-gray-100 border rounded">{{ $proposal->ghocs_element }}</p>
                </div>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Location</label>
                <p class="p-2 bg-gray-100 border rounded">{{ $proposal->location }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Budget</label>
                <p class="p-2 bg-gray-100 border rounded">{{ $proposal->budget }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Additional Info</label>
                <p class="p-2 bg-gray-100 border rounded">{{ $proposal->additional_info }}</p>
            </div>

            <div>
                <label class="font-semibold text-gray-700">Proposal File</label><br>
                <a href="{{ asset('storage/' . $proposal->proposal_file) }}" target="_blank"
                    class="text-blue-600 underline">View Proposal PDF</a>
            </div>

        </div>

        <div class="flex justify-center space-x-2">

            @if ($proposal->status === 'Pending' && Auth::id() === $proposal->club->advisor_id)
                <div class="mt-6 flex flex-col items-center gap-4 w-full">

                    {{-- Action Buttons --}}
                    <div class="flex gap-3">
                        {{-- Approve --}}
                        <form action="{{ route('manageactivity.approve', [$proposal->club_id, $proposal->id]) }}"
                            method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                Approve Proposal
                            </button>
                        </form>

                        {{-- Reject Toggle --}}
                        <button type="button"
                            onclick="document.getElementById('rejectForm-{{ $proposal->id }}').classList.toggle('hidden')"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Reject Proposal
                        </button>
                    </div>

                    {{-- Reject Form (Expands Downwards) --}}
                    <form id="rejectForm-{{ $proposal->id }}"
                        action="{{ route('manageactivity.reject', [$proposal->club_id, $proposal->id]) }}" method="POST"
                        class="hidden w-full max-w-3xl mt-2">
                        @csrf

                        <label class="block font-semibold mb-1 text-gray-700">
                            Rejection Remark
                        </label>

                        <textarea name="remarks" rows="4" required placeholder="Enter reason for rejection"
                            class="w-full border px-3 py-2 rounded border-gray-400
                       hover:border-orange-500 hover:bg-gray-50
                       focus:border-2 focus:border-orange-500 focus:outline-none"></textarea>

                        <button type="submit" class="mt-3 px-4 py-2 bg-red-700 text-white rounded hover:bg-red-800">
                            Submit Rejection
                        </button>
                    </form>

                </div>
            @endif


        </div>
        <a href="{{ route('manageactivity.show', $proposal->club_id) }}"
            class="px-4 py-2 inline-block bg-gray-400 text-white rounded hover:bg-gray-500 mt-10">
            Back to Manage Activity
        </a>
    </div>
@endsection

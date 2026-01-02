@extends('layoutStyle.styling')
{{-- after approved, High Com can post it. --}}
@section('content')
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 mb-10">
        <h2 class="text-2xl font-bold mb-6 text-black-700">Post Approved Activity</h2>

        {{-- Success / Error Messages --}}
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        {{-- Activity Posting Form --}}
        <form action="{{ route('postactivity.store', $proposal->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Hidden Inputs for Database Fields --}}
            <input type="hidden" name="activity_title" value="{{ $proposal->activity_title }}">
            <input type="hidden" name="activity_description" value="{{ $proposal->activity_description }}">
            <input type="hidden" name="activity_date" value="{{ $proposal->activity_date }}">
            <input type="hidden" name="activity_date_end" value="{{ $proposal->activity_date_end }}">
            <input type="hidden" name="level" value="{{ $proposal->level }}">
            <input type="hidden" name="dna_category" value="{{ $proposal->dna_category }}">
            <input type="hidden" name="ghocs_element" value="{{ $proposal->ghocs_element }}">
            <input type="hidden" name="location" value="{{ $proposal->location }}">
            <input type="hidden" name="budget" value="{{ $proposal->budget }}">
            <input type="hidden" name="additional_info" value="{{ $proposal->additional_info }}">
            <input type="hidden" name="proposal_file" value="{{ $proposal->proposal_file }}">

            {{-- Optional: Show read-only info to user --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Activity Title</label>
                <p class="p-2 border rounded bg-gray-100">{{ $proposal->activity_title }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Activity Description</label>
                <textarea name="activity_description" rows="5"
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">{{ old('activity_description', $proposal->activity_description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Activity Date</label>
                <p class="p-2 border rounded bg-gray-100">
                    {{ $proposal->activity_date }}
                    @if ($proposal->activity_date_end)
                        - {{ $proposal->activity_date_end }}
                    @endif
                </p>
            </div>

            <div class="mb-4 grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold">Level</label>
                    <p class="p-2 border rounded bg-gray-100">{{ $proposal->level }}</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">DNA Category</label>
                    <p class="p-2 border rounded bg-gray-100">{{ $proposal->dna_category }}</p>
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold">GHOCS Element</label>
                    <p class="p-2 border rounded bg-gray-100">{{ $proposal->ghocs_element }}</p>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Location</label>
                <p class="p-2 border rounded bg-gray-100">{{ $proposal->location }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Budget</label>
                <p class="p-2 border rounded bg-gray-100">{{ $proposal->budget }}</p>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Additional Info</label>
                <p class="p-2 border rounded bg-gray-100">{{ $proposal->additional_info }}</p>
            </div>

            {{-- Activity Image Upload --}}
            <div class="mb-6">
                <label for="poster_image" class="block text-gray-700 font-semibold">Activity Poster</label>

                {{-- Show current poster if available --}}
                @if ($proposal->poster_image)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $proposal->poster_image) }}" alt="Current Poster"
                            class="w-64 h-auto border rounded">
                    </div>
                @endif

                {{-- File input to replace poster --}}
                <input type="file" name="poster_image" id="poster_image" accept="image/*"
                    class="w-full mt-1 p-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500">

                <p class="text-sm text-gray-500 mt-1">
                    You can replace the current poster (JPG, PNG only, max 5MB). Leave blank to keep the existing poster.
                </p>
            </div>


            {{-- Submit Button --}}
            <div class="flex justify-end space-x-3">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Post Activity
                </button>

                <a href="{{ route('club.show', $proposal->club_id) }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection

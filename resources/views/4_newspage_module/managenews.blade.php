@extends('layoutStyle.styling')

{{-- Admin add News/Non CLub Activity without needing Proposal (Self post) --}}
@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow mt-10 mb-10">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">Add News/Non-Club Activity</h2>

        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- News Title --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">News Title</label>
                <input type="text" name="news_name"
                    value="{{ session('from_proposal') ? session('proposal_data.news_name') : old('news_name') }}"
                    placeholder="Insert activity's title..."
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                    required>

                @error('news_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">Description</label>
                <textarea name="news_description" rows="4" placeholder="Insert activity's description..."
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                    required>{{ session('from_proposal') ? session('proposal_data.news_description') : old('news_description') }}</textarea>
                @error('news_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label class="block font-semibold mb-2">Image (optional)</label>

                <div
                    class="w-full border border-gray-400 rounded px-3 py-2
               hover:border-orange-500 hover:bg-gray-50
               focus:border-2 focus:border-orange-500 focus:outline-none
               cursor-pointer">
                    {{-- If image came from proposal, show preview --}}
                    @if (session('proposal_data.image'))
                        <div class="mb-2">
                            <p class="text-sm text-gray-600">Using image from approved proposal:</p>
                            <img src="{{ asset('storage/' . session('proposal_data.image')) }}" alt="Proposal Image"
                                class="w-40 h-40 object-cover rounded border">
                        </div>

                        {{-- Store image path so the controller knows --}}
                        <input type="hidden" name="proposal_image" value="{{ session('proposal_data.image') }}">
                    @endif

                    {{-- Actual file upload --}}
                    <input type="file" name="image" accept="image/*" class="w-full">

                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- GHOCS Claimable Checkbox --}}
            <div class="mb-4">
                <label class="inline-flex items-center space-x-2">
                    <input type="checkbox" id="ghocs_toggle" name="is_ghocs" class="h-5 w-5 text-orange-500"
                        {{ session('from_proposal') ? 'checked disabled' : (old('is_ghocs') ? 'checked' : '') }}>
                    <span class="font-semibold text-gray-700">Is this GHOCS-claimable?</span>
                </label>

                @if (session('from_proposal'))
                    <p class="text-sm text-gray-500 ml-7">This proposal requires GHOCS fields.</p>
                @endif
            </div>

            {{-- These fields will be hidden unless checkbox is checked --}}
            <div id="ghocs_fields" class="{{ session('from_proposal') || old('is_ghocs') ? '' : 'hidden' }}">

                {{-- Level --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">Activity Level</label>
                    <select name="level" id="level_field" class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                        <option value="">Select Activity Level</option>
                        <option value="Campus Level"
                            {{ session('proposal_data.level') == 'Campus Level' ? 'selected' : '' }}>Campus</option>
                        <option value="University Level"
                            {{ session('proposal_data.level') == 'University Level' ? 'selected' : '' }}>University
                        </option>
                        <option value="National Level"
                            {{ session('proposal_data.level') == 'National Level' ? 'selected' : '' }}>National</option>
                        <option value="International Level"
                            {{ session('proposal_data.level') == 'International Level' ? 'selected' : '' }}>International
                        </option>
                    </select>

                </div>

                {{-- DNA Category --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">UniKL DNA Program Component Category</label>
                    <select name="dna_category" id="dna_field" class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                        <option value="">Select Category</option>
                        <option value="Active Programme"
                            {{ session('proposal_data.dna_category') == 'Active Programme' ? 'selected' : '' }}>Active
                            Programme
                        </option>
                        <option value="Sports & Recreation"
                            {{ session('proposal_data.dna_category') == 'Sports & Recreation' ? 'selected' : '' }}>Sports &
                            Recreation
                        </option>
                        <option value="Entrepreneur"
                            {{ session('proposal_data.dna_category') == 'Entrepreneur' ? 'selected' : '' }}>Entrepreneur
                        </option>
                        <option value="Global" {{ session('proposal_data.dna_category') == 'Global' ? 'selected' : '' }}>
                            Global
                        </option>
                        <option value="Graduate"
                            {{ session('proposal_data.dna_category') == 'Graduate' ? 'selected' : '' }}>
                            Graduate
                        </option>
                        <option value="Leadership"
                            {{ session('proposal_data.dna_category') == 'Leadership' ? 'selected' : '' }}>
                            Leadership
                        </option>
                    </select>
                </div>

                {{-- GHOCS --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-semibold">GHOCS Element</label>
                    <select name="ghocs_element" id="ghocs_field" class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                        <option value="">Select Activity Domain</option>
                        <option value="Spiritual"
                            {{ session('proposal_data.ghocs_element') == 'Spiritual' ? 'selected' : '' }}>
                            Spiritual</option>
                        <option value="Physical"
                            {{ session('proposal_data.ghocs_element') == 'Physical' ? 'selected' : '' }}>
                            Physical</option>
                        <option value="Intellectual"
                            {{ session('proposal_data.ghocs_element') == 'Intellectual' ? 'selected' : '' }}>Intellectual
                        </option>
                        <option value="Career" {{ session('proposal_data.ghocs_element') == 'Career' ? 'selected' : '' }}>
                            Career
                        </option>
                        <option value="Emotional"
                            {{ session('proposal_data.ghocs_element') == 'Emotional' ? 'selected' : '' }}>
                            Emotional</option>
                        <option value="Social" {{ session('proposal_data.ghocs_element') == 'Social' ? 'selected' : '' }}>
                            Social
                        </option>
                    </select>
                </div>

                {{-- Activity Date Start --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Activity Date Start</label>
                    <input type="date" name="activity_date" id="activity_date_start"
                        value="{{ isset(session('proposal_data')['activity_date'])
                            ? \Carbon\Carbon::parse(session('proposal_data')['activity_date'])->format('Y-m-d')
                            : old('activity_date') }}"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                </div>

                {{-- Activity Date End --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Activity Date End</label>
                    <input type="date" name="activity_date_end" id="activity_date_end"
                        value="{{ isset(session('proposal_data')['activity_date_end'])
                            ? \Carbon\Carbon::parse(session('proposal_data')['activity_date_end'])->format('Y-m-d')
                            : old('activity_date_end') }}"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                </div>

                {{-- Location --}}
                <div class="mb-4">
                    <label class="block font-semibold mb-2">Location</label>
                    <input type="text" name="location"
                        value="{{ session('proposal_data.location') ?? old('location') }}"
                        placeholder="Insert activity's proposed locatiom..."
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                    @error('location')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex justify-center space-x-3">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg">
                    Submit
                </button>
                <a href="{{ route('news.index') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">
                    Back
                </a>
            </div>
        </form>

        {{-- JavaScript to toggle GHOCS fields --}}
        <script>
            const toggle = document.getElementById('ghocs_toggle');
            const fields = document.getElementById('ghocs_fields');

            const level = document.getElementById('level_field');
            const dna = document.getElementById('dna_field');
            const ghocs = document.getElementById('ghocs_field');
            const dateStart = document.getElementById('activity_date_start');
            const dateEnd = document.getElementById('activity_date_end');

            toggle.addEventListener('change', () => {
                if (toggle.checked) {
                    fields.classList.remove('hidden');

                    // Make fields required
                    level.setAttribute('required', 'required');
                    dna.setAttribute('required', 'required');
                    ghocs.setAttribute('required', 'required');
                    dateStart.setAttribute('required', 'required');
                    dateEnd.setAttribute('required', 'required');

                } else {
                    fields.classList.add('hidden');

                    // Remove required attribute
                    level.removeAttribute('required');
                    dna.removeAttribute('required');
                    ghocs.removeAttribute('required');
                    dateStart.removeAttribute('required');
                    dateEnd.removeAttribute('required');
                }
            });
            window.addEventListener('load', () => {
                if (toggle.checked) {
                    level.setAttribute('required', 'required');
                    dna.setAttribute('required', 'required');
                    ghocs.setAttribute('required', 'required');
                    dateStart.setAttribute('required', 'required');
                    dateEnd.setAttribute('required', 'required');
                }
            });
        </script>
    </div>
    </div>
@endsection

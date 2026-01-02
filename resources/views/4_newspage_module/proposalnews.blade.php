@extends('layoutStyle.styling')
<!-- Section where student/club advisor submit non club activity for SDCL to approve on the main News page -->
@section('content')
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-lg shadow mt-10 mb-10">

        <div x-data="{ activeTab: 1 }" class="w-full max-w-4xl mx-auto px-14">

            <!-- Tab Headers -->
            <div class="flex border-b border-gray-300 mb-4">
                <button @click="activeTab = 1"
                    :class="activeTab === 1 ? 'bg-orange-600 text-white shadow-md' :
                        'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Non- Club Activity Proposal Form
                </button>
                <button @click="activeTab = 2"
                    :class="activeTab === 2 ? 'bg-orange-600 text-white shadow-md' :
                        'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Proposal Status
                </button>
            </div>

            <!-- Tab Content -->
            <div>
                <!-- Tab 1 Content -->
                <div x-show="activeTab === 1" class="max-w-6xl mx-auto mt-10 ">
                    <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center border-b ">Request Non-Club Activity
                    </h2>

                    <form action="{{ route('proposalnews.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Proposed Activity Title</label>
                            <input type="text" name="proposal_news_name" value="{{ old('proposal_news_name') }}"
                                placeholder="Insert activity's title..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                            @error('proposal_news_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Proposed Activity Description</label>
                            <textarea name="proposal_news_description" rows="4" placeholder="Insert activity's description..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>{{ old('proposal_news_description') }}</textarea>
                            @error('proposal_news_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Activity Image (Poster/Illustration)</label>
                            <input type="file" name="image" accept="image/*"
                                class="w-full border border-gray-400 rounded px-3 py-2
               hover:border-orange-500 hover:bg-gray-50
               focus:border-2 focus:border-orange-500 focus:outline-none
               cursor-pointer">
                            @error('image')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Activity Proposal PDF</label>
                            <input type="file" name="proposal_pdf" accept="application/pdf"
                                class="w-full border border-gray-400 rounded px-3 py-2
               hover:border-orange-500 hover:bg-gray-50
               focus:border-2 focus:border-orange-500 focus:outline-none
               cursor-pointer"
                                required>
                            @error('proposal_pdf')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Activity Budget (RM)</label>
                            <input type="number" name="budget" value="{{ old('budget') }}"
                                placeholder="Insert activity's estimated budget..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                            @error('budget')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Location</label>
                            <input type="text" name="location" value="{{ old('location') }}"
                                placeholder="Insert activity's proposed locatiom..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Activity Date Start</label>
                            <input type="date" name="activity_date" value="{{ old('activity_date') }}"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Activity Date End</label>
                            <input type="date" name="activity_date_end" value="{{ old('activity_date_end') }}"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                        </div>

                        <div class="mb-4">
                            <label class="block font-semibold mb-2">Additional Remark (Optional)</label>
                            <textarea name="additional_description" rows="3"
                                placeholder="Involved staff's details, vehicle requires, any additional information..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">{{ old('additional_description') }}</textarea>
                            @error('additional_description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="inline-flex items-center space-x-2">
                                <input type="checkbox" id="ghocs_toggle" name="is_ghocs" class="h-5 w-5 text-orange-500"
                                    {{ old('is_ghocs') ? 'checked' : '' }}>
                                <span class="font-semibold text-gray-700">Is this GHOCS-claimable?</span>
                            </label>
                        </div>

                        <div id="ghocs_fields" class="{{ old('is_ghocs') ? '' : 'hidden' }}">
                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold">Activity Level</label>
                                <select name="level" id="level_field"
                                    class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                                    <option value="">Select Activity Level</option>
                                    <option value="Campus Level">Campus</option>
                                    <option value="University Level">University</option>
                                    <option value="National Level">National</option>
                                    <option value="International Level">International</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold">UniKL DNA Program Component
                                    Category</label>
                                <select name="dna_category" id="dna_field"
                                    class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required>
                                    <option value="">Select Category</option>
                                    <option value="Active Programme">Active Programme</option>
                                    <option value="Sports & Recreation">Sports & Recreation</option>
                                    <option value="Entrepreneur">Entrepreneur</option>
                                    <option value="Global">Global</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Leadership">Leadership</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 font-semibold">Activity Domain (S.P.I.C.E.S)</label>
                                <select name="ghocs_element" id="ghocs_field"
                                    class="border px-3 py-2 mb-2 mt-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required>
                                    <option value="">Select Activity Domain</option>
                                    <option value="Spiritual">Spiritual</option>
                                    <option value="Physical">Physical</option>
                                    <option value="Intellectual">Intellectual</option>
                                    <option value="Career">Career</option>
                                    <option value="Emotional">Emotional</option>
                                    <option value="Social">Social</option>
                                </select>
                            </div>

                        </div>

                        {{-- JS to toggle fields --}}
                        <script>
                            const toggle = document.getElementById('ghocs_toggle');
                            const fields = document.getElementById('ghocs_fields');

                            const level = document.getElementById('level_field');
                            const dna = document.getElementById('dna_field');
                            const ghocs = document.getElementById('ghocs_field');

                            toggle.addEventListener('change', () => {
                                if (toggle.checked) {
                                    fields.classList.remove('hidden');
                                    level.setAttribute('required', 'required');
                                    dna.setAttribute('required', 'required');
                                    ghocs.setAttribute('required', 'required');
                                } else {
                                    fields.classList.add('hidden');
                                    level.removeAttribute('required');
                                    dna.removeAttribute('required');
                                    ghocs.removeAttribute('required');
                                }
                            });
                        </script>

                        @php
                            $hasPending = $proposalNews->where('status', 'pending')->count() > 0;
                        @endphp
                        <div class="flex justify-center space-x-3 mt-6">
                            <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg {{ $hasPending ? 'opacity-50 cursor-not-allowed' : '' }}"
                                {{ $hasPending ? 'disabled' : '' }}>
                                Submit
                            </button>
                            <a href="{{ route('news.index') }}"
                                class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">Back to News Main
                                Page</a>
                        </div>
                        @if ($hasPending)
                            <p class="text-red-500 text-sm mt-2 text-center">You cannot submit a new proposal while a
                                previous one is
                                still pending.</p>
                        @endif
                    </form>
                </div>

                <!-- Tab 2 Content -->
                <div x-show="activeTab === 2" class="max-w-6xl mx-auto mt-10 ">
                    {{-- --------------------------- Table Section --------------------------- --}}
                    <h2 class="text-12xl font-semibold text-orange-600 mb-6 text-center border-b ">Submitted Proposal</h2>

                    @if ($proposalNews->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border text-black rounded-lg">
                                <thead class="bg-blue-800  text-bold text-white">
                                    <tr>
                                        <th class="px-4 py-2 border text-center">No</th>
                                        <th class="px-4 py-2 border text-center">Activity Name</th>
                                        <th class="px-4 py-2 border text-center">Budget (RM)</th>
                                        <th class="px-4 py-2 border text-center">Location</th>
                                        <th class="px-4 py-2 border text-center">Activity Dates</th>
                                        <th class="px-4 py-2 border text-center">GHOCS Element</th>
                                        <th class="px-4 py-2 border text-center">Status</th>
                                        <th class="px-4 py-2 border text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposalNews as $proposal)
                                        <tr class="text-center">
                                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                                            <td class="px-4 py-2 border">{{ $proposal->proposal_news_name }}</td>
                                            <td class="px-4 py-2 border">{{ $proposal->budget ?? '-' }}</td>
                                            <td class="px-4 py-2 border">{{ $proposal->location ?? '-' }}</td>
                                            <td class="px-4 py-2 border">
                                                {{ $proposal->activity_date ? $proposal->activity_date->format('d M Y') : '-' }}
                                                -
                                                {{ $proposal->activity_date_end ? $proposal->activity_date_end->format('d M Y') : '-' }}
                                            </td>
                                            <td class="px-4 py-2 border">{{ $proposal->ghocs_element ?? '-' }}</td>
                                            <td class="px-4 py-2 border capitalize">
                                                {{ $proposal->status }}
                                            </td>
                                            <td class="px-4 py-2 border">
                                                <a href="{{ route('proposalnews.show', $proposal->id) }}"
                                                    class="text-blue-500 hover:underline">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $proposalNews->links('pagination::tailwind') }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No proposals submitted yet.</p>
                    @endif

                    <div class="flex justify-center space-x-3 mt-6">
                        <a href="{{ route('news.index') }}"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">Back to News Main Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Include Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    </div>


@endsection

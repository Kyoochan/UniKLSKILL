@extends('layoutStyle.styling')
{{-- student propose an activity that is GHOCS claimable for advisor to approve --}}
@section('content')

    {{-- Activity Proposals Table --}}
    <div class=" w-6xl mx-auto mt-10 mb-10 bg-white shadow-lg rounded-lg p-6">

        <div x-data="{ tab: 1 }" class="max-w-4xl mx-auto mt-8">

            <!-- Tab Buttons -->
            <div class="flex border-b border-gray-300 mb-4">
                <button :class="tab === 1 ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                    @click="tab = 1">
                    Propose New Activity
                </button>
                <button :class="tab === 2 ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                    @click="tab = 2">
                    View Submission Status
                </button>
            </div>

            <!-- Tab Content -->
            <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
                <!-- Container for Tab 1 -->
                <div x-show="tab === 1" x-transition>
                    <div class="flex items-center text-center ">
                        <h2 class="text-2xl font-bold mb-4 text-black-700 text-center">Propose New Activity for
                            {{ $club->clubname }}</h2>

                        {{-- Tooltip --}}
                        <div class="relative group flex items-center ml-2 -mt-3">
                            <span
                                class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                title="Information">?</span>
                            <div
                                class="absolute left-7 top-1/2 -translate-y-1/2 w-72 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                Propose a new activity for this club. Fill in the details and upload the activity
                                proposal form (PDF).
                            </div>
                        </div>
                    </div>

                    {{-- Error Display --}}
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>⚠️ {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Activity Proposal Form --}}
                    <form action="{{ route('proposeactivity.store', $club->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label for="activity_title" class="block text-gray-700 font-semibold">Activity Title</label>
                            <input type="text" name="activity_title" id="activity_title"
                                placeholder="Insert activity's title..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                        </div>

                        <div class="mb-4">
                            <label for="activity_description" class="block text-gray-700 font-semibold">Activity
                                Description</label>
                            <textarea name="activity_description" id="activity_description" rows="5"
                                placeholder="Insert activity's description..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required></textarea>
                        </div>

                        {{-- Activity Poster --}}
                        <div class="mb-4">
                            <label for="poster_image" class="block text-gray-700 font-semibold">
                                Activity Poster (Image)
                            </label>

                            <input type="file" name="poster_image" id="poster_image" accept="image/*"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400
               hover:border-orange-500 hover:bg-gray-50
               focus:border-2 focus:border-orange-500 focus:outline-none">

                            <p class="text-sm text-gray-500">
                                Accepted formats: JPG, PNG, JPEG (Max 5MB)
                            </p>
                        </div>

                        <div class="mb-4">
                            <label for="activity_date" class="block text-gray-700 font-semibold">Activity Start
                                Date</label>
                            <input type="date" name="activity_date" id="activity_date" required
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                        </div>

                        <div class="mb-4">
                            <label for="activity_date_end" class="block text-gray-700 font-semibold">Activity End
                                Date</label>
                            <input type="date" name="activity_date_end" id="activity_date_end" required
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                        </div>

                        {{-- Level --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold">Activity Level</label>
                            <select name="level"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                required>
                                <option value="">Select Activity Level</option>
                                <option value="Campus Level">Campus</option>
                                <option value="University Level">University</option>
                                <option value="National Level">National</option>
                                <option value="International Level">International</option>
                            </select>
                        </div>

                        {{-- DNA Category --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold">UniKL DNA Program Component
                                Category</label>
                            <select name="dna_category"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
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

                        {{-- GHOCS --}}
                        <div class="mb-4">
                            <label class="block text-gray-700 font-semibold">GHOCS Element</label>
                            <select name="ghocs_element"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
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

                        {{-- Location --}}
                        <div class="mb-4">
                            <label for="location" class="block text-gray-700 font-semibold">Location</label>
                            <input type="text" name="location" id="location"
                                placeholder="Insert location or venue of activity"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"required>
                        </div>

                        {{-- Budget --}}
                        <div class="mb-4">
                            <label for="budget" class="block text-gray-700 font-semibold">Budget</label>
                            <input type="text" name="budget" id="budget"
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                placeholder="e.g., RM 500">
                        </div>

                        {{-- Additional Information --}}
                        <div class="mb-4">
                            <label for="additional_info" class="block text-gray-700 font-semibold">Additional
                                Information</label>
                            <textarea name="additional_info" id="additional_info" rows="4"
                                placeholder="Optional information such as vehicle status, staff attending/required,PIC during activity day..."
                                class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"></textarea>
                        </div>


                        <div class="mb-6">
                            <div class="relative group flex items-center">
                                <label for="proposal_file" class="block text-gray-700 font-semibold">Download Activity
                                    Proposal Form
                                    (PDF)</label>

                                {{-- Tooltip --}}
                                <div class="relative group flex items-center ml-2">
                                    <span
                                        class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                        title="Information">?</span>
                                    <div
                                        class="absolute left-7 top-1/2 -translate-y-1/2 w-72 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                        Download the club activity proposal form template.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="proposal_file" class="block text-gray-700 font-semibold">Upload Proposal Form
                                (PDF)</label>
                            <input type="file" name="proposal_file" id="proposal_file" accept="application/pdf"
                                required
                                class="w-full mt-1 p-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex justify-right space-x-4">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Submit Proposal
                            </button>

                            <a href="{{ route('club.show', $club->id) }}"
                                class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                                Back to {{ $club->clubname }} Page
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Container for Tab 2 -->
                <div x-show="tab === 2" x-transition>
                    <h3 class="text-xl font-bold mb-4 text-gray-800 text-center">Submitted Activity Proposals</h3>
                    <h4 class="text-md mb-6 text-gray-600 text-center">View the status of your submitted activity
                        proposals
                        for
                        {{ $club->clubname }}. After your activity proposal has been approved, you may click the post
                        activity button for other club members to view and participate in the activity.</h4>

                    @if ($proposals->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full border border-gray-300 rounded-lg">
                                <thead class="bg-blue-800 text-white text-bold">
                                    <tr>
                                        <th class="py-2 px-3 text-left">No</th>
                                        <th class="py-2 px-3 text-left">Title</th>
                                        <th class="py-2 px-3 text-left">Date</th>
                                        <th class="py-2 px-3 text-left">Status</th>
                                        <th class="py-2 px-3 text-left">Proposal PDF</th>
                                        <th class="py-2 px-3 text-left">Submitted At</th>
                                        <th class="py-2 px-3 text-center">Actions</th>
                                        <th class="py-2 px-3 text-center">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($proposals as $index => $proposal)
                                        <tr class="border-t hover:bg-gray-50">
                                            <td class="py-2 px-3">{{ $proposals->firstItem() + $index }}</td>
                                            <td class="py-2 px-3 font-semibold text-gray-800">
                                                {{ $proposal->activity_title }}</td>
                                            <td class="py-2 px-3">
                                                {{ \Carbon\Carbon::parse($proposal->activity_date)->format('d M Y') }}
                                            </td>

                                            {{-- Status --}}
                                            <td class="py-2 px-3">
                                                @if ($proposal->status === 'Pending')
                                                    <span class="text-yellow-600 font-semibold">Pending</span>
                                                @elseif ($proposal->status === 'Approved')
                                                    <span class="text-green-600 font-semibold">Approved</span>
                                                @else
                                                    <span class="text-red-600 font-semibold">Rejected</span>
                                                @endif
                                            </td>

                                            {{-- File --}}
                                            <td class="py-2 px-3">
                                                @if ($proposal->proposal_file)
                                                    <a href="{{ asset('storage/' . $proposal->proposal_file) }}"
                                                        target="_blank" class="text-blue-600 underline">View PDF</a>
                                                @else
                                                    <span class="text-gray-500">No File</span>
                                                @endif
                                            </td>

                                            <td class="py-2 px-3">{{ $proposal->created_at->format('d M Y, h:i A') }}</td>

                                            {{-- Actions Column --}}
                                            <td class="py-2 px-3 text-center">
                                                <div class="flex justify-center space-x-2">
                                                    {{-- Post Activity Button (only for Approved) --}}
                                                    @if ($proposal->status === 'Approved')
                                                        <a href="{{ route('postactivity.show', $proposal->id) }}"
                                                            class="w-20 bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                                            Post Activity
                                                        </a>
                                                    @endif

                                                    {{-- Delete Button --}}
                                                    <form
                                                        action="{{ route('proposeactivity.destroy', [$club->id, $proposal->id]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this activity proposal request?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-20 bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                            Delete request
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td class="py-2 px-3 text-center">
                                                {{ $proposal->remarks ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- Pagination --}}
                        <div class="mt-6 flex justify-center text-gray-700">
                            {{ $proposals->links('pagination::tailwind') }}
                        </div>
                    @else
                        <p class="text-gray-600">No activity proposals submitted yet.</p>
                    @endif
                    <div class="flex justify-left mt-10">

                        <a href="{{ route('club.show', $club->id) }}"
                            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                            Back to {{ $club->clubname }} Page
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Make sure Alpine.js is included -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>


    {{-- 🔹 Added space before next section --}}


@endsection

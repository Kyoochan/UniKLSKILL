@extends('layoutStyle.styling')
{{-- Student submit GHOC request + view all submitted GHOC request status --}}
@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-lg p-6 sm:p-8">

            <h1 class="text-3xl font-bold mb-6 text-center">My Excellence Proposal</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ===================== TAB SYSTEM (ALPINE.JS) ===================== --}}
            <div x-data="{ openTab: 1 }">

                {{-- TAB BUTTONS --}}
                <div class="flex mb-6 border-b">

                    <!-- Submit Proposal Tab -->
                    <button @click="openTab = 1"
                        :class="openTab === 1 ?
                            'bg-orange-500 text-white shadow-md border-b-4 border-orange-700' :
                            'text-gray-600 hover:text-orange-700 hover:bg-orange-50'"
                        class="px-5 py-2 font-semibold rounded-t-lg transition duration-200">
                        Submit Proposal
                    </button>

                    <!-- View Requests Tab -->
                    <button @click="openTab = 2"
                        :class="openTab === 2 ?
                            'bg-orange-500 text-white shadow-md border-b-4 border-orange-700' :
                            'text-gray-600 hover:text-orange-700 hover:bg-orange-50'"
                        class="px-5 py-2 font-semibold rounded-t-lg transition duration-200">
                        View Requests
                    </button>
                </div>

                {{-- TAB CONTENT 1 --}}
                <div x-show="openTab === 1" id="submitTab" x-transition>
                    <div class="mt-1">
                        <h4 class="text-3xl font-bold mb-6 text-center">New Request</h4>

                        {{-- ===================== SUBMIT TAB ===================== --}}
                        <form action="{{ route('merit.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- ================= REFERENCE SELECTION ================= --}}
                            <div class="mb-6 border p-4 rounded-lg bg-gray-50">
                                <h2 class="text-lg font-semibold mb-4">Reference Existing Activity / News (Optional)
                                    <!-- Tooltip Trigger -->
                                    <span class="relative group mx-2">
                                        <span class="text-gray-700 font-bold cursor-pointer">?</span>

                                        <!-- Tooltip Box -->
                                        <span
                                            class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg
               opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-50">
                                            Search and select existing GHOCS claimable activity from non-club activity from
                                            News Page or Clubs you had joined to avoid manually filling the request form.
                                        </span>
                                    </span>
                                </h2>

                                <select name="reference_id" id="referenceId"
                                    class="w-full border p-2 rounded mb-3 bg-white">
                                    <option value="">Type Activity/News name to search...</option>

                                    <optgroup label="Posted Activities">
                                        @foreach ($activities as $a)
                                            <option value="{{ $a->id }}" data-type="activity"
                                                data-clubname="{{ $a->club ? $a->club->clubname : '' }}"
                                                data-title="{{ $a->activity_title }}" data-ghocs="{{ $a->ghocs_element }}"
                                                data-level="{{ $a->level }}" data-dna="{{ $a->dna_category }}"
                                                data-date="{{ $a->activity_date ? \Carbon\Carbon::parse($a->activity_date)->format('Y-m-d') : '' }}">
                                                {{ $a->activity_title }}
                                            </option>
                                        @endforeach
                                    </optgroup>

                                    <optgroup label="News">
                                        @foreach ($news as $n)
                                            <option value="{{ $n->id }}" data-type="news"
                                                data-title="{{ $n->news_name }}" data-ghocs="{{ $n->ghocs_element }}"
                                                data-level="{{ $n->level }}" data-dna="{{ $n->dna_category }}"
                                                data-date="{{ $n->created_at->format('Y-m-d') }}">
                                                {{ $n->news_name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                </select>

                                <input type="hidden" name="reference_type" id="referenceType">
                            </div>

                            {{-- ================= ACTIVITY DETAILS ================= --}}
                            <div class="mb-6 border p-4 rounded-lg ">
                                <h2 class="text-lg font-semibold mb-4">Activity Details</h2>

                                <label class="font-semibold">Activity Title</label>
                                <input type="text" name="title" id="titleInput"
                                    placeholder="Insert activity's title..."
                                    class="border px-3 py-2 mt-1 mb-4 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required>

                                <label class="font-semibold">Activity Level</label>
                                <select name="level" id="level_field"
                                    class="border px-3 py-2 mt-1 mb-4 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                                    <option value="">Select Activity Level</option>
                                    <option value="Campus Level">Campus</option>
                                    <option value="University Level">University</option>
                                    <option value="National Level">National</option>
                                    <option value="International Level">International</option>
                                </select>

                                <label class="font-semibold ">UniKL DNA Category</label>
                                <select name="dna_category" id="dna_field"
                                    class="border px-3 py-2 mt-1 mb-4 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                                    <option value="">Select Category</option>
                                    <option value="Active Programme">Active Programme</option>
                                    <option value="Sports & Recreation">Sports & Recreation</option>
                                    <option value="Entrepreneur">Entrepreneur</option>
                                    <option value="Global">Global</option>
                                    <option value="Graduate">Graduate</option>
                                    <option value="Leadership">Leadership</option>
                                </select>

                                <label class="font-semibold">GHOCS Element</label>
                                <select name="ghocs_element" id="ghocs_field"
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                                    <option value="">Select Domain</option>
                                    <option value="Spiritual">Spiritual</option>
                                    <option value="Physical">Physical</option>
                                    <option value="Intellectual">Intellectual</option>
                                    <option value="Career">Career</option>
                                    <option value="Emotional">Emotional</option>
                                    <option value="Social">Social</option>
                                </select>

                                <label class="font-semibold">Activity Date</label>
                                <input type="date" name="activity_date" id="dateInput"
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                            </div>

                            {{-- =============== ADDITIONAL REQUIRED INPUTS =============== --}}
                            <div class="mb-6 border p-4 rounded-lg">
                                <h2 class="text-lg font-semibold mb-4">Additional Required Details</h2>

                                <label class="font-semibold">Achievement Level
                                    <!-- Tooltip Trigger -->
                                    <span class="relative group">
                                        <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                        <!-- Tooltip Box -->
                                        <span
                                            class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                            Achievement level contributes to Excellence point for your account.
                                        </span>
                                    </span>
                                </label>

                                <select name="achievement_level"
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required>
                                    <option value="">Select Achievement Level</option>
                                    <option value="Representative">Representative</option>
                                    <option value="Special Award">Special Award</option>
                                    <option value="Participate">Participate (Special Invitation)</option>
                                    <option value="International Short Sem">International Buddy (Short Semester)</option>
                                    <option value="International Full Sem">International Buddy (Full Semester)</option>
                                    <option value="Exchange Short Sem">Exchange Students (Short Semester)</option>
                                    <option value="Exchange Full Sem">Exchange Students (Full Semester)</option>
                                </select>

                                <label class="font-semibold">Description</label>
                                <textarea name="description" rows="4"
                                placeholder="Either this is grouped or individual activity, The placement you had gotten (1st place, participant) or other.."
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required></textarea>

                                <label class="font-semibold">Upload Evidence (Image/PDF)</label>
                                <input type="file" name="evidence"
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    required>
                            </div>

                            {{-- SUBMIT BUTTON --}}
                            <div class="mb-4 ">
                                <button type="submit"
                                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 flex-1 text-center">
                                    Submit Merit Proposal
                                </button>

                                <a href="{{ route('curriculumPage.show') }}"
                                    class="bg-orange-400 text-white  px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center">
                                    Back to Curriculum Page
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                {{-- TAB CONTENT 2 --}}
                <div x-show="openTab === 2" id="viewTab" x-transition>
                    {{-- ===================== VIEW REQUESTS TAB ===================== --}}
                    <div class="mt-1">
                        <h2 class="text-xl font-semibold mb-4">Your Submitted Requests</h2>

                        <table class="w-full border rounded-lg">
                            <thead class="bg-blue-800 text-white text-center">
                                <tr>
                                    <th class="p-2 border">Title</th>
                                    <th class="p-2 border">DNA Domain</th>
                                    <th class="p-2 border">S.P.I.C.E Element</th>
                                    <th class="p-2 border">Activity Level</th>
                                    <th class="p-2 border">Approval Status</th>
                                    <th class="p-2 border">Submitted Date</th>
                                    <th class="p-2 border">Rejection Reasoning</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($myRequests as $req)
                                    <tr class="hover:bg-gray-50">
                                        <td class="p-2 border">{{ $req->title }}</td>
                                        <td class="p-2 border">{{ $req->dna_category }}</td>
                                        <td class="p-2 border">{{ $req->ghocs_element }}</td>
                                        <td class="p-2 border">{{ $req->level }}</td>
                                        <td class="p-2 border">
                                            @if ($req->status == 'approved')
                                                <span class="text-green-600 font-bold">Approved</span>
                                            @elseif ($req->status == 'rejected')
                                                <span class="text-red-600 font-bold">Rejected</span>
                                            @else
                                                <span class="text-yellow-600 font-bold">Pending</span>
                                            @endif
                                        </td>
                                        <td class="p-2 border">{{ $req->created_at->format('d M Y') }}</td>
                                        <td class="p-2 border">
                                            @if ($req->status == 'rejected')
                                                {{ $req->admin_comment }}
                                            @else
                                                N/A
                                            @endif
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-3 text-center text-gray-500">No requests submitted
                                            yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-10">
                        <a href="{{ route('curriculumPage.show') }}"
                            class="bg-orange-400 text-white  px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center">
                            Back to Curriculum Page
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ===================== SCRIPTS ===================== --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {

            // SELECT2
            $('#referenceId').select2({
                placeholder: "Type Activity/News name to search...",
                allowClear: true,
                width: '100%',
                templateResult: function(option) {
                    if (!option.element) return option.text;
                    let clubname = $(option.element).data('clubname') || '';
                    let date = $(option.element).data('date') || '';
                    return clubname ? `${option.text} (club: ${clubname}, ${date})` : option.text;
                },
                templateSelection: function(option) {
                    if (!option.element) return option.text;
                    let clubname = $(option.element).data('clubname') || '';
                    let date = $(option.element).data('date') || '';
                    return clubname ? `${option.text} (club: ${clubname}, ${date})` : option.text;
                }
            });

            // Autofill logic
            $('#referenceId').on('change', function() {
                let selected = $(this).find(':selected');
                let type = selected.data('type') || '';
                $('#referenceType').val(type);

                if (!this.value) {
                    $('#titleInput').val('').prop('readonly', false);
                    $('#ghocs_field').val('').prop('disabled', false);
                    $('#level_field').val('').prop('disabled', false);
                    $('#dna_field').val('').prop('disabled', false);
                    $('#dateInput').val('');
                } else {
                    $('#titleInput').val(selected.data('title')).prop('readonly', true);
                    $('#ghocs_field').val(selected.data('ghocs')).prop('disabled', true);
                    $('#level_field').val(selected.data('level')).prop('disabled', true);
                    $('#dna_field').val(selected.data('dna')).prop('disabled', true);
                    $('#dateInput').val(selected.data('date'));
                }
            });
        });

        // TAB SWITCHING
        document.getElementById("tabSubmit").addEventListener("click", function() {
            document.getElementById("submitTab").classList.remove("hidden");
            document.getElementById("viewTab").classList.add("hidden");

            this.classList.add("border-blue-600", "text-blue-600");
            document.getElementById("tabView").classList.remove("border-blue-600", "text-blue-600");
        });

        document.getElementById("tabView").addEventListener("click", function() {
            document.getElementById("submitTab").classList.add("hidden");
            document.getElementById("viewTab").classList.remove("hidden");

            this.classList.add("border-blue-600", "text-blue-600");
            document.getElementById("tabSubmit").classList.remove("border-blue-600", "text-blue-600");
        });
    </script>
@endsection

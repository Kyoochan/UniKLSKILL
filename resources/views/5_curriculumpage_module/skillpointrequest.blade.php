@extends('layoutStyle.styling')

@section('content')
    <div x-data="{ tab: 'submit' }" class="max-w-4xl mx-auto mt-10 mb-10 p-6 bg-white rounded shadow">

        <div class="flex space-x-4 mb-6">
            <button
                :class="tab === 'submit' ? 'bg-orange-600 text-white shadow-md' :
                    'text-gray-600 hover:bg-orange-100'"
                class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                @click="tab = 'submit'">Submit Skill Development Proposal</button>

            <button
                :class="tab === 'view' ? 'bg-orange-600 text-white shadow-md' :
                    'text-gray-600 hover:bg-orange-100'"
                class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200"
                @click="tab = 'view'">View Request Status</button>
        </div>

        <!-- Submit Proposal Tab -->
        <div x-show="tab === 'submit'">
            <h2 class="item-center justify-center text-2xl font-bold mb-6">Submit Skill Development Proposal</h2>
            <h2 class="item-center justify-center text-lg mb-4 border-2 py-2 px-2 rounded-md text-center text-gray-700">Skill Development is for students who have completed several
                selected common subject and wish to gain additional skill development points.</h2>

            @if (session('success'))
                <div class="bg-green-200 p-3 mb-4 rounded">{{ session('success') }}</div>
            @endif

            <form action="{{ route('skill_proposals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Proposal Title</label>
                    <input type="text" name="title" placeholder="Insert proposal's title..."
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>
                    @error('title')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Upload Result (PDF)
                        <!-- Tooltip Trigger -->
                        <span class="relative group">
                            <span class="text-black-700 font-bold cursor-pointer">?</span>

                            <!-- Tooltip Box -->
                            <span
                                class="z-50 absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                Upload your result transcript in PDF format as evidence that you have completed the subject
                                you are proposing for skill development points.
                            </span>
                        </span></label>
                    <input type="file" name="pdf_file" accept="application/pdf"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>
                    @error('pdf_file')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1 font-semibold">Select Common General Subject</label>
                    <select name="subject_name"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required>
                        @foreach ($subjects as $subject)
                            <option value="{{ $subject['name'] }}" data-points="{{ $subject['points'] }}">
                                {{ $subject['name'] }} {{-- ({{ $subject['points'] }} points) --}}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="subject_points" id="subject_points">
                    @error('subject_name')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit"
                    class="bg-blue-500 text-white  px-6 py-3 rounded-lg hover:bg-blue-600 flex-1 text-center">
                    Submit Proposal
                </button>

                <a href="{{ route('curriculumPage.show') }}"
                    class="bg-orange-400 text-white  px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center">
                    Back to Curriculum Page
                </a>
            </form>
        </div>

        <!-- View Submitted Proposals Tab -->
        <div x-show="tab === 'view'">
            <h2 class="text-2xl font-bold mb-4">Your Submitted Proposals</h2>
            @if ($proposals->isEmpty())
                <p>No proposals submitted yet.</p>
            @else
                <table class="w-full table-auto border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-orange-400 text-white">
                            <th class="border p-2">Proposal Name</th>
                            <th class="border p-2">Subject Choosen</th>
                            <th class="border p-2">Points Eligible</th>
                            <th class="border p-2">Approval Status</th>
                            <th class="border p-2">Result Transcript</th>
                            <th class="border p-2">Submitted Date</th>
                            <th class="border p-2">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proposals as $proposal)
                            <tr>
                                <td class="border p-2">{{ $proposal->title }}</td>
                                <td class="border p-2">{{ $proposal->subject_name }}</td>
                                <td class="border p-2">{{ $proposal->subject_points }}</td>
                                @if ($proposal->approval_status === 'approved')
                                    <td class="border p-2 text-green-600 font-semibold">Approved</td>
                                @elseif ($proposal->approval_status === 'rejected')
                                    <td class="border p-2 text-red-600 font-semibold">Rejected</td>
                                @else
                                    <td class="border p-2 text-gray-600 font-semibold">Pending</td>
                                @endif
                                </td>
                                <td class="border p-2">
                                    <a href="{{ asset('storage/' . $proposal->pdf_file) }}" target="_blank"
                                        class="text-blue-500 underline">View PDF</a>
                                </td>
                                <td class="border p-2">{{ $proposal->created_at->format('Y-m-d H:i') }}</td>
                                <td class="border p-2">{{ $proposal->secretary_remark ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            <div class="mb-4 mt-6">

                <a href="{{ route('curriculumPage.show') }}"
                    class="bg-orange-400 text-white  px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center">
                    Back to Curriculum Page
                </a>
            </div>
        </div>
    </div>

    <script>
        const select = document.querySelector('select[name="subject_name"]');
        const pointsInput = document.getElementById('subject_points');

        function updatePoints() {
            pointsInput.value = select.selectedOptions[0].dataset.points;
        }

        if (select && pointsInput) {
            select.addEventListener('change', updatePoints);
            updatePoints(); // initialize
        }
    </script>
@endsection

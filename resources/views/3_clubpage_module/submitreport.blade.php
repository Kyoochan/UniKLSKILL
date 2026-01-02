@extends('layoutStyle.styling')

@section('content')
    <div x-data="{ tab: 'one' }" class="max-w-6xl mx-auto bg-white p-8 shadow rounded-lg mt-10 mb-10">

        <!-- TAB BUTTONS -->
        <div class="flex border-b border-gray-300">
            <button @click="tab = 'one'"
                :class="tab === 'one' ? 'bg-orange-600 text-white shadow-md' :
                    'text-gray-600 hover:bg-orange-100'"
                class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                Report Submission
            </button>

            <button @click="tab = 'two'"
                :class="tab === 'two' ? 'bg-orange-600 text-white shadow-md' :
                    'text-gray-600 hover:bg-orange-100'"
                class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                View Report
            </button>
        </div>

        <!-- TAB CONTENT -->
        <div class="p-6 bg-white shadow">
            <!-- TAB ONE -->
            <div x-show="tab === 'one'" x-transition>
                <div class="mt-4">
                    <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">Submit Club Activity Report</h2>

                    {{-- Submit Report Form --}}
                    <form action="{{ route('submitreport.store', $club->id) }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf
                        <a href=""></a>
                        {{-- Title --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Title of Report</label>
                            <input type="text" name="title"
                                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-orange-400" required>
                        </div>

                        {{-- Description --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Description</label>
                            <textarea name="description" rows="4" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-orange-400"
                                required></textarea>
                        </div>

                        {{-- Reference --}}
                        <div>
                            <div class="flex items-center mb-2 space-x-2">
                                <label class="text-gray-700 font-medium">Reference</label>

                                {{-- Tooltip beside label --}}
                                <div class="relative group">
                                    <span
                                        class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                        title="Information">?</span>

                                    <div
                                        class="absolute left-6 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                        Select the type of reference first, then choose the specific activity or
                                        announcement posted by
                                        the club.
                                    </div>
                                </div>
                            </div>

                            <select name="reference_type" id="reference_type" class="w-full border rounded-lg p-2 mb-2">
                                <option value="">Select Reference Type</option>
                                <option value="activity">Activity</option>
                                <option value="announcement">Announcement</option>
                            </select>

                            <select name="reference_id" id="reference_id" class="w-full border rounded-lg p-2">
                                <option value="">Select Posted Club Activities As Reference</option>

                                {{-- Activities (only show those without a report) --}}
                                @foreach ($activities as $activity)
                                    @php
                                        $hasReport = $reports->contains('reference_id', $activity->id);
                                    @endphp
                                    @if (!$hasReport)
                                        <option value="{{ $activity->id }}" data-type="activity">
                                            {{ $activity->activity_title }}
                                        </option>
                                    @endif
                                @endforeach

                                {{-- Announcements (only show those without a report) --}}
                                @foreach ($announcements as $announcement)
                                    @php
                                        $hasReport = $reports->contains('reference_id', $announcement->id);
                                    @endphp
                                    @if (!$hasReport)
                                        <option value="{{ $announcement->id }}" data-type="announcement">
                                            {{ $announcement->title }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        {{-- Attachment --}}
                        <div>
                            <div class="flex items-center mb-2 space-x-2">
                                <label class="text-gray-700 font-medium "required>Club Report Form (PDF)</label>

                                {{-- Tooltip beside label --}}
                                <div class="relative group">
                                    <span
                                        class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                        title="Information">?</span>

                                    <div
                                        class="absolute left-6 top-1/2 -translate-y-1/2 w-64 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                        Download and refer to the provided PDF guide on how to fill the club activity
                                        report.
                                    </div>
                                </div>
                            </div>

                            <input type="file" name="attachment" class="w-full border rounded-lg p-2"
                                accept=".pdf,.doc,.docx,.png,.jpg,.jpeg">
                        </div>

                        {{-- Submit + Back --}}
                        <div class="text-center">
                            <button type="submit"
                                class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg shadow">
                                Submit Report
                            </button>
                        </div>

                        <a href="{{ route('club.show', $club->id) }}"
                            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition inline-block mt-3">
                            Back to {{ $club->clubname }} Page
                        </a>
                    </form>
                </div>
            </div>
            <!-- TAB TWO -->
            <div x-show="tab === 'two'" x-transition>
                {{-- 📋 Table Section --}}
                <div class="mt-10">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Submitted Report Overview</h3>

                    <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
                        <thead class="bg-orange-500 text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">Title</th>
                                <th class="px-4 py-2 text-left">Type</th>
                                <th class="px-4 py-2 text-left">Report Submitted</th>
                                <th class="px-4 py-2 text-left">Advisor Remark</th>
                                <th class="px-4 py-2 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            {{-- Activities --}}
                            @foreach ($activities as $activity)
                                @php
                                    $report = $reports->first(function ($r) use ($activity) {
                                        return $r->reference_id == $activity->id && $r->reference_type == 'activity';
                                }); @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $activity->activity_title }}</td>
                                    <td class="px-4 py-2">Activity</td>
                                    <td class="px-4 py-2">
                                        @if ($report)
                                            Yes ({{ $report->title }})
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($report && $report->advisor_remarks)
                                            <span class="text-gray-700">{{ $report->advisor_remarks }}</span>
                                        @else
                                            <span class="text-gray-400 italic">No remarks</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($report)
                                            <a href="{{ route('report.view', $report->id) }}"
                                                class="text-blue-600 hover:underline">
                                                View Report
                                            </a>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            {{-- Announcements --}}
                            @foreach ($announcements as $announcement)
                                @php
                                    $report = $reports->first(function ($r) use ($announcement) {
                                        return $r->reference_id == $announcement->id &&
                                            $r->reference_type == 'announcement';
                                    });
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2">{{ $announcement->title }}</td>
                                    <td class="px-4 py-2">Announcement</td>
                                    <td class="px-4 py-2">
                                        @if ($report)
                                            Yes ({{ $report->title }})
                                        @else
                                            No
                                        @endif
                                    </td>
                                    <td class="px-4 py-2">
                                        @if ($report && $report->advisor_remarks)
                                            <span class="text-gray-700">{{ $report->advisor_remarks }}</span>
                                        @else
                                            <span class="text-gray-400 italic">No remarks</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if ($report)
                                            <a href="{{ route('report.view', $report->id) }}"
                                                class="text-blue-600 hover:underline">
                                                View Report
                                            </a>
                                        @else
                                            <span class="text-gray-400">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-6">
                    <a href="{{ route('club.show', $club->id) }}"
                        class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition inline-block mt-3">
                        Back to {{ $club->clubname }} Page
                    </a>
                </div>
            </div>

        </div>
    </div>
    </div>

    {{-- 🧠 Dynamic Filtering Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const typeSelect = document.getElementById('reference_type');
            const refSelect = document.getElementById('reference_id');
            const allOptions = Array.from(refSelect.options);

            typeSelect.addEventListener('change', () => {
                const selectedType = typeSelect.value;
                refSelect.innerHTML = '<option value="">-- Select Reference --</option>';
                allOptions.forEach(option => {
                    if (option.dataset.type === selectedType) {
                        refSelect.appendChild(option);
                    }
                });
            });
        });
    </script>
@endsection

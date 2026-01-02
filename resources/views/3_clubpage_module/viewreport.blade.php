@extends('layoutStyle.styling')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-8 shadow rounded-lg mt-10 mb-10">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">
            Club Activity Reports for {{ $club->clubname }}
        </h2>

        {{-- Reports Table --}}
        <table class="min-w-full border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Category</th>
                    <th class="px-4 py-2 text-left">Submitted By</th>
                    <th class="px-4 py-2 text-left">Advisor Remark</th>
                    <th class="px-4 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">

                {{-- Activities --}}
                @foreach ($activities as $activity)
                    @php
                        $report = $reports->first(
                            fn($r) => $r->reference_id == $activity->id && $r->reference_type == 'activity',
                        );
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $activity->activity_title }}</td>
                        <td class="px-4 py-2">Activity</td>
                        <td class="px-4 py-2">
                            @if ($report)
                                {{ $report->student?->name ?? 'Unknown Student' }}
                            @else
                                <span class="text-gray-400 italic">No Report</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if ($report && $report->advisor_remarks)
                                {{ $report->advisor_remarks }}
                            @elseif ($report)
                                <a href="{{ route('report.remark', $report->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                                    Add Remark
                                </a>
                            @else
                                <span class="text-gray-400 italic">No Report</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($report)
                                <a href="{{ route('report.remark', $report->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                                    Edit Remark
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach

                {{-- Announcements --}}
                @foreach ($announcements as $announcement)
                    @php
                        $report = $reports->first(
                            fn($r) => $r->reference_id == $announcement->id && $r->reference_type == 'announcement',
                        );
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $announcement->title }}</td>
                        <td class="px-4 py-2">Announcement</td>
                        <td class="px-4 py-2">
                            @if ($report)
                                {{ $report->student?->name ?? 'Unknown Student' }}
                            @else
                                <span class="text-gray-400 italic">No Report</span>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            @if ($report && $report->advisor_remarks)
                                {{ $report->advisor_remarks }}
                            @elseif ($report)
                                <a href="{{ route('report.remark', $report->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                                    Add Remark
                                </a>
                            @else
                                <span class="text-gray-400 italic">No Report</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($report)
                                <a href="{{ route('report.remark', $report->id) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                                    Edit Remark
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <a href="{{ route('club.show', $club->id) }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
            Back to Club Page
        </a>
    </div>
@endsection

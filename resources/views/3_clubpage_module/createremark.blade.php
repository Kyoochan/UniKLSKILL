@extends('layoutStyle.styling')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-8 shadow rounded-lg mt-10 mb-10">
        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">
            Add Remark for Report
        </h2>

        {{-- Report Details --}}
        <div class="mb-6 space-y-3 p-4 border rounded-lg bg-gray-50">
            <p><strong>Title:</strong> {{ $report->title ?? 'N/A' }}</p>
            <p><strong>Description:</strong> {{ $report->description ?? 'N/A' }}</p>
            <p><strong>Submitted By:</strong> {{ $report->student->name ?? 'Unknown' }}</p>
            <p><strong>Reference:</strong>
                @if ($report->reference_type === 'activity')
                    Activity: {{ $report->activity?->activity_title ?? 'N/A' }}
                @elseif ($report->reference_type === 'announcement')
                    Announcement: {{ $report->announcement?->title ?? 'N/A' }}
                @else
                    N/A
                @endif
            </p>
            @if ($report->attachment)
                <p><strong>Activity Report PDF:</strong>
                    <a href="{{ asset('storage/' . $report->attachment) }}" target="_blank"
                        class="text-blue-600 hover:underline">View/Download</a>
                </p>
            @endif
        </div>

        {{-- Add Remark Form --}}
        <form action="{{ route('report.remark.store', $report->id) }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-gray-700 font-medium mb-2">Advisor Remark</label>
                <textarea name="advisor_remarks" rows="4" required
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-orange-400">{{ old('advisor_remarks', $report->advisor_remarks) }}</textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-2 rounded-lg shadow">
                    Save Remark
                </button>
            </div>

            <a href="{{ route('viewreport.show', $club->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                Back to Club Page
            </a>
        </form>
    </div>
@endsection

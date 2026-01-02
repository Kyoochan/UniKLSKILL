@extends('layoutStyle.styling')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 mb-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold mb-6 text-center">Skill Development Points Approval</h2>

        @if (session('success'))
            <div class="bg-green-200 p-3 mb-4 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full border-collapse border overflow-x-auto">
            <thead class="bg-orange-500 text-white">
                <tr>
                    <th class="border p-2">Student Name</th>
                    <th class="border p-2">Submission Title</th>
                    <th class="border p-2">Subject Requested</th>
                    <th class="border p-2">Points Eligible</th>
                    <th class="border p-2">Subject's Result Slip</th>
                    <th class="border p-2">Approval Status</th>
                    <th class="border p-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($proposals as $proposal)
                    <tr>
                        <td class="border p-2">{{ $proposal->user->name ?? 'N/A' }}</td>
                        <td class="border p-2">{{ $proposal->title }}</td>
                        <td class="border p-2">{{ $proposal->subject_name }}</td>
                        <td class="border p-2">{{ $proposal->subject_points }}</td>
                        <td class="border p-2">
                            <a href="{{ asset('storage/' . $proposal->pdf_file) }}" target="_blank"
                                class="text-blue-600 underline">
                                View PDF
                            </a>
                        </td>
                        <td class="border p-2 capitalize">
                            {{ $proposal->approval_status }}
                        </td>

                        <td class="border p-2">
                            @if ($proposal->approval_status === 'pending')
                                <div x-data="{ showReject: false }">

                                    {{-- Approve --}}
                                    <form action="{{ route('skill_proposals.approve', $proposal->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button class="bg-green-500 text-white px-3 py-1 rounded">
                                            Approve
                                        </button>
                                    </form>

                                    {{-- Deny button --}}
                                    <button @click="showReject = !showReject"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded ml-2 mt-2">
                                        Reject
                                    </button>

                                    {{-- Reject form (hidden until Deny clicked) --}}
                                    <form x-show="showReject" x-transition
                                        action="{{ route('skill_proposals.reject', $proposal->id) }}" method="POST"
                                        class="mt-2">
                                        @csrf

                                        <textarea name="secretary_remark" class="w-full border rounded p-1 text-sm" placeholder="Reason for rejection" required></textarea>

                                        <button class="bg-red-500 text-white px-3 py-1 rounded mt-1">
                                            Submit Rejection
                                        </button>
                                    </form>

                                </div>
                            @else
                                <span class="text-gray-500 font-semibold">Processed</span>

                                @if ($proposal->secretary_remark)
                                    <div class="text-sm text-red-600 mt-1">
                                        Remark: {{ $proposal->secretary_remark }}
                                    </div>
                                @endif
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('curriculumPage.show') }}"
            class="bg-orange-400 text-white  px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center mt-6 inline-block">
            Back to GHOCS Page
        </a>
    </div>
@endsection

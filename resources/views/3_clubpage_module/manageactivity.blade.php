@extends('layoutStyle.styling')
{{-- advisor see all submission of club activity and approve/reject it --}}
@section('content')
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6 mt-10 mb-10">
        <h2 class="text-2xl font-bold mb-4 text-black-700">Manage {{ $club->clubname }} Activity Proposal</h2>

        {{-- Flash messages --}}
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        @if ($proposals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-lg">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="py-2 px-3 text-center">No</th>
                            <th class="py-2 px-3 text-center">Title</th>
                            <th class="py-2 px-3 text-center">Proposed By</th>
                            <th class="py-2 px-3 text-center">Date</th>
                            <th class="py-2 px-3 text-center">Proposal form</th>
                            <th class="py-2 px-3 text-center">Status</th>
                            <th class="py-2 px-3 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proposals as $index => $proposal)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="py-2 px-3">{{ $proposals->firstItem() + $index }}</td>
                                <td class="py-2 px-3 font-semibold text-gray-800">{{ $proposal->activity_title }}</td>
                                <td class="py-2 px-3">{{ $proposal->proposer->name }}</td>
                                <td class="py-2 px-3">{{ \Carbon\Carbon::parse($proposal->activity_date)->format('d M Y') }}
                                </td>
                                <td class="py-2 px-3">
                                    @if ($proposal->proposal_file)
                                        <a href="{{ asset('storage/' . $proposal->proposal_file) }}" target="_blank"
                                            class="text-blue-600 underline">View PDF</a>
                                    @else
                                        <span class="text-gray-500">No File</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">
                                    @if ($proposal->status === 'Pending')
                                        <span class="text-yellow-600 font-semibold">Pending</span>
                                    @elseif ($proposal->status === 'Approved')
                                        <span class="text-green-600 font-semibold">Approved</span>
                                    @else
                                        <span class="text-red-600 font-semibold">Rejected</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3 text-center">
                                    @if ($proposal->status === 'Pending')
                                        <div class="flex justify-center space-x-2">
                                            <a href="{{ route('postactivity.view', $proposal->id) }}"
                                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                                View Proposal
                                            </a>

                                            {{--  <form action="{{ route('manageactivity.approve', [$club->id, $proposal->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">Approve</button>
                                            </form>
                                            <form action="{{ route('manageactivity.reject', [$club->id, $proposal->id]) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Reject</button>
                                            </form> --}}

                                        </div>
                                    @else
                                        <span class="text-gray-500">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex justify-center">
                {{ $proposals->links('pagination::tailwind') }}
            </div>
        @else
            <p class="text-gray-600">No activity proposals submitted yet for this club.</p>
        @endif

        <a href="{{ route('club.show', $club->id) }}"
            class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
            Back to {{ $club->clubname }} Page
        </a>

    </div>
@endsection

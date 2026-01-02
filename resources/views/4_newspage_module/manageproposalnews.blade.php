@extends('layoutStyle.styling')

{{-- admin view all submitted proposal --}}
@section('content')
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow mt-10 mb-10">

        <h2 class="text-2xl font-semibold text-orange-600 mb-6 text-center">
            Manage Non-Club Activity Proposals
        </h2>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if ($proposalNews->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full border border-gray-300 rounded-lg">
                    <thead class="bg-blue-800 text-white">
                        <tr>
                            <th class="px-4 py-2 border">No</th>
                            <th class="px-4 py-2 border">Activity Name</th>
                            <th class="px-4 py-2 border">Submitted By</th>
                            <th class="px-4 py-2 border">Dates</th>
                            <th class="px-4 py-2 border">Budget (RM)</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($proposalNews as $proposal)
                            <tr class="text-center">
                                <td class="px-4 py-2 border">{{ $loop->iteration }}</td>

                                <td class="px-4 py-2 border">
                                    {{ $proposal->proposal_news_name }}
                                </td>

                                <td class="px-4 py-2 border">
                                    {{ $proposal->user->name ?? 'Unknown' }}
                                </td>

                                <td class="px-4 py-2 border">
                                    {{ $proposal->activity_date ? $proposal->activity_date->format('d M Y') : '-' }}
                                    <br>
                                    {{ $proposal->activity_date_end ? $proposal->activity_date_end->format('d M Y') : '-' }}
                                </td>

                                <td class="px-4 py-2 border">
                                    {{ $proposal->budget ?? '-' }}
                                </td>

                                {{-- Status with badge color --}}
                                <td class="px-4 py-2 border font-semibold">
                                    @if ($proposal->status === 'pending')
                                        <span class="text-yellow-600">Pending</span>
                                    @elseif($proposal->status === 'approved')
                                        <span class="text-green-600">Approved</span>
                                    @else
                                        <span class="text-red-600">Rejected</span>
                                    @endif
                                </td>

                                <td class="px-4 py-2 border space-x-2">

                                    {{-- View Button --}}
                                    <a href="{{ route('proposalnews.show', $proposal->id) }}"
                                        class="text-blue-500 hover:underline">
                                        View
                                    </a>

                                    {{-- Approve Button --}}
                                    @if ($proposal->status == 'pending')
                                        <form action="{{ route('proposalnews.approve', $proposal->id) }}" method="POST"
                                            class="inline-block">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-green-600 hover:underline">
                                                Approve
                                            </button>
                                        </form>

                                        {{-- Reject Button --}}
                                        <form action="{{ route('proposalnews.reject', $proposal->id) }}" method="POST"
                                            class="inline-block ml-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 hover:underline">
                                                Reject
                                            </button>
                                        </form>
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <div class="mt-6">
                {{ $proposalNews->links('pagination::tailwind') }}
            </div>
        @else
            <p class="text-gray-500 text-center">No proposals submitted yet.</p>
        @endif

        <a href="{{ route('news.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">Back</a>
    </div>
@endsection

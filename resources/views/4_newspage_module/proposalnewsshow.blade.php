@extends('layoutStyle.styling')

<!-- Section student/advisor view appending/approve/rejected proposal daripada proposalnews punya table -->
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow mt-10 mb-10 ">
        <h2 class="text-2xl font-extrabold text-orange-600 mb-6 text-center">
            VIEW PROPOSED ACTIVITY
        </h2>

        <div class="mb-4 border-1 px-2 py-2 rounded-lg">
            <h3 class="font-bold text-black mb-1">Title:</h3>
            <p class="text-gray-800">{{ $proposalNews->proposal_news_name  }}</p>
        </div>

        @if ($proposalNews->image)
            <div class="mb-4 px-2 py-2 rounded-lg border-1 px-2 py-2 rounded-lg">
                <h3 class="font-bold text-black ">Image:</h3>
                <img src="{{ asset('storage/' . $proposalNews->image) }}" alt="Proposal Image"
                    class="w-full h-full flex items-center justify-center rounded scale-90 ">
            </div>
        @endif

        <div class="mb-4 border-1 px-2 py-2 rounded-lg">
            <h3 class="font-bold text-black mb-1">Description:</h3>
            <p class="text-gray-800">{{ $proposalNews->proposal_news_description }}</p>
        </div>

        @if ($proposalNews->proposal_pdf)
            <div class="mb-4 border-1 px-2 py-2 rounded-lg">
                <h3 class="font-bold text-black mb-1 ">Proposal PDF:</h3>
                <a href="{{ asset('storage/' . $proposalNews->proposal_pdf) }}" target="_blank"
                    class="text-blue-500 hover:underline ">
                    View / Download PDF
                </a>
            </div>
        @endif

        <div class="mb-4 border-1 px-2 py-2 rounded-lg">
            <h3 class="font-bold text-black mb-1">Budget:</h3>
            <p class="text-gray-800">{{ $proposalNews->budget ? 'RM ' . number_format($proposalNews->budget, 2) : '-' }}</p>
        </div>

        @if ($proposalNews->additional_description)
            <div class="mb-4 border-1 px-2 py-2 rounded-lg">
                <h3 class="font-bold text-black mb-1">Additional Remark:</h3>
                <p class="text-gray-800">{{ $proposalNews->additional_description }}</p>
            </div>
        @endif

        <div class="mb-4 border-1 px-2 py-2 rounded-lg">
            <h3 class="font-bold text-black mb-1">GHOCS Details:</h3>
            <ul class="list-disc list-inside text-gray-800">
                <li><b>GHOCS Element:</b> {{ $proposalNews->ghocs_element ?? '-' }}</li>
                <li><b>Level:</b> {{ $proposalNews->level ?? '-' }}</li>
                <li><b>DNA Category:</b> {{ $proposalNews->dna_category ?? '-' }}</li>
                <li><b>Location:</b> {{ $proposalNews->location ?? '-' }}</li>
                <li><b>Activity Dates:</b>
                    {{ $proposalNews->activity_date ? $proposalNews->activity_date->format('d M Y') : '-' }}
                    -
                    {{ $proposalNews->activity_date_end ? $proposalNews->activity_date_end->format('d M Y') : '-' }}
                </li>
            </ul>
        </div>

        @auth
            @if (Auth::user()->userRole === 'admin')
                <a href="{{ route('proposalnews.manage') }}"
                    class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">
                    Back to Manage Proposals
                </a>
            @elseif (Auth::user()->userRole === 'student')
                <div class="mt-6 text-center">
                    <a href="{{ route('proposalnews.create') }}"
                        class="bg-gray-400 hover:bg-gray-500 text-white px-6 py-2 rounded-lg">
                        Back to Proposals
                    </a>
                </div>
            @endif
        @endauth
    </div>
@endsection

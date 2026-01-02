@extends('layoutStyle.styling')
{{-- secretary view submitted GHOC proposal --}}
@section('content')
    <div class="min-h-screen bg-gray-100 py-10">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6">
            <h1 class="text-3xl font-bold mb-6 text-center border-b">GHOCS Details - {{ $proposal->title }}</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                <div>
                    <div>
                        <h2 class="text-2xl text-black font-bold text-center">Activity Proposal Status</h2>
                        <p
                            class="border-1 px-2 py-2 mt-4 mb-10 rounded-lg hover:bg-gray-50 text-center text-3xl uppercase font-bold">
                            {{ $proposal->status }}</p>
                    </div>

                    <h2 class="text-1xl text-black font-bold">Student Name </h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->user?->name ?? 'N/A' }}
                        ({{ $proposal->user?->student_id ?? '' }})</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Activity Title</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->title }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Activity Domain (SPICES)</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->ghocs_element }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">DNA Programme Category</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->dna_category }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Activity Level</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->level }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Student's Achievement Level</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->achievement_level }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Activity Date</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">
                        {{ $proposal->activity_date ? \Carbon\Carbon::parse($proposal->activity_date)->format('d M Y') : 'N/A' }}
                    </p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Activity Description</h2>
                    <p class="border-1 px-2 py-2 mt-1 rounded-lg hover:bg-gray-50">{{ $proposal->description }}</p>
                </div>

                <div>
                    <h2 class="text-1xl text-black font-bold">Evidence of Participation</h2>
                    @if ($proposal->evidence)
                        <a href="{{ asset('storage/' . $proposal->evidence) }}" target="_blank"
                            class="text-blue-600 underline">
                            View Evidence
                        </a>
                    @else
                        <p>N/A</p>
                    @endif
                </div>

                @if ($proposal->status === 'rejected' && $proposal->admin_comment)
                    <div>
                        <h2 class="font-semibold text-red-600">Rejection Comment</h2>
                        <p>{{ $proposal->admin_comment }}</p>
                    </div>
                @endif
            </div>

            {{-- Approve / Reject Actions --}}
            @if ($proposal->status === 'pending')
                <div class="mt-6 flex justify-center gap-4">
                    {{-- Approve --}}
                    <form action="{{ route('merit.approve', $proposal->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg">
                            Approve GHOCS
                        </button>
                    </form>

                    {{-- Reject: Show comment textarea --}}
                    <button id="showRejectFormBtn" type="button"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg">
                        Reject with Remark
                    </button>
                </div>

                {{-- Reject Form (hidden initially) --}}
                <form id="rejectForm" action="{{ route('merit.reject', $proposal->id) }}" method="POST"
                    class="mt-4 hidden">
                    @csrf
                    <label for="admin_comment" class="font-semibold">Rejection Comment</label>
                    <textarea name="admin_comment" id="admin_comment" rows="4" placeholder="Reason of rejection"
                        class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                        required></textarea>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg">
                        Submit Rejection
                    </button>
                </form>
            @endif

            <div class="mt-6 text-center">
                <a href="{{ route('merit.manage') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                    Back to Pending Requests
                </a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('showRejectFormBtn')?.addEventListener('click', function() {
            document.getElementById('rejectForm').classList.toggle('hidden');
        });
    </script>
@endsection

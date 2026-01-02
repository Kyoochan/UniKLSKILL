@extends('layoutStyle.styling')
{{-- Admin see all pending club proposals + change template of the club proposal from time to time --}}
@section('content')
    <div x-data="{ tab: 'tab1' }" class="w-full max-w-5xl mx-auto mt-8">
        <div class="w-10/12 mx-auto mt-10 mb-10 bg-white p-6 rounded-lg shadow-md">

            <!-- Tabs -->
            <div class="flex border-b space-x-2">
                <button @click="tab = 'tab1'"
                    :class="tab === 'tab1' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Club Request
                </button>

                <button @click="tab = 'tab2'"
                    :class="tab === 'tab2' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Club Proposal Template
                </button>
            </div>

            <!-- Tab Content -->
            <!-- Tab 1 Content -->
            <div x-show="tab === 'tab1'" x-cloak x-transition>
                {{-- ---------------------------------------- Pending Proposals Section ------------------------ --}}
                <div class="w-full bg-white p-6 rounded-lg shadow-md flex flex-col gap-8 mx-auto mt-10">

                    <h2 class="text-2xl font-bold mb-4 text-center">Pending Club Proposals</h2>

                    @if ($pendingProposals->isEmpty())
                        <p class="text-gray-600">No pending proposals found.</p>
                    @else
                        <table class="w-full border-collapse border border-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="border p-2 text-left">Club Name</th>
                                    <th class="border p-2 text-left">Submitted By</th>
                                    <th class="border p-2 text-left">Date</th>
                                    <th class="border p-2 text-left">Status</th>
                                    <th class="border p-2 text-center">View Proposal</th>
                                    <th class="border p-2 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pendingProposals as $proposal)
                                    <tr>
                                        <td class="border p-2 max-w-xs truncate" title="{{ $proposal->clubname }}">
                                            {{ $proposal->clubname }}
                                        </td>
                                        <td class="border p-2">{{ $proposal->student_name ?? 'Unknown' }}</td>
                                        <td class="border p-2">
                                            {{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y') }}
                                        </td>
                                        <td class="border p-2 max-w-xs truncate" title="{{ $proposal->status }}">
                                            {{ $proposal->status }}
                                        </td>
                                        <td class="border p-2 text-center">
                                            <a href="{{ asset('storage/' . $proposal->proposal_pdf) }}" target="_blank"
                                                class="text-blue-600 hover:underline">View PDF</a>
                                        </td>
                                        <td class="border p-2 text-center">

                                            @if ($proposal->status === 'pending')
                                                <div class="flex justify-center gap-2">
                                                    {{-- Approve --}}
                                                    <form action="{{ route('club.request.approve', $proposal->id) }}"
                                                        method="POST" class="inline-block">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                            Approve
                                                        </button>
                                                    </form>

                                                    {{-- Reject: show remark form --}}
                                                    <button type="button"
                                                        onclick="document.getElementById('rejectForm-{{ $proposal->id }}').classList.toggle('hidden')"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Reject
                                                    </button>
                                                </div>

                                                {{-- Reject Form (hidden initially) --}}
                                                <form id="rejectForm-{{ $proposal->id }}"
                                                    action="{{ route('club.request.reject', $proposal->id) }}"
                                                    method="POST" class="mt-3 hidden">
                                                    @csrf

                                                    <label class="block font-semibold mb-1">
                                                        Rejection Remark
                                                    </label>

                                                    <textarea name="remarks" rows="3" required placeholder="Enter reason for rejection"
                                                        class="w-full border px-3 py-2 rounded border-gray-400
                   hover:border-orange-500 hover:bg-gray-50
                   focus:border-2 focus:border-orange-500 focus:outline-none">
        </textarea>

                                                    <button type="submit"
                                                        class="mt-2 px-4 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Submit Rejection
                                                    </button>
                                                </form>
                                            @elseif ($proposal->status === 'approved')
                                                <a href="{{ route('club.create', ['proposal_id' => $proposal->id]) }}"
                                                    class="inline-block px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700">
                                                    Create
                                                </a>

                                                {{-- Delete after approve --}}
                                                <form action="{{ route('club.request.delete', $proposal->id) }}"
                                                    method="POST" class="inline-block ml-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            @elseif ($proposal->status === 'rejected')
                                                {{-- Delete after reject --}}
                                                <form action="{{ route('club.request.delete', $proposal->id) }}"
                                                    method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                                        Delete
                                                    </button>
                                                </form>
                                            @endif


                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4 flex justify-center items-center gap-4 text-gray-700">
                            {{-- Page info --}}
                            <span>
                                Page {{ $pendingProposals->currentPage() }} of {{ $pendingProposals->lastPage() }}
                            </span>

                            {{-- Previous Page Link --}}
                            @if ($pendingProposals->onFirstPage())
                                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">Prev</span>
                            @else
                                <a href="{{ $pendingProposals->previousPageUrl() }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Prev</a>
                            @endif

                            {{-- Next Page Link --}}
                            @if ($pendingProposals->hasMorePages())
                                <a href="{{ $pendingProposals->nextPageUrl() }}"
                                    class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700">Next</a>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-500 rounded cursor-not-allowed">Next</span>
                            @endif
                        </div>
                    @endif

                    <a href="{{ route('club.index') }}"
                        class="ml-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded w-40">
                        Back to Club Page
                    </a>

                </div>

            </div>


            <!-- Tab 2 Content -->
            <div x-show="tab === 'tab2'" x-cloak x-transition>
                <div class="w-10/12 bg-white p-6 rounded-lg shadow-md flex flex-col gap-8 mx-auto mt-10">

                    <h2 class="text-2xl font-bold mb-4 text-center">Manage Proposal Template</h2>

                    @if (session('error'))
                        <div class="bg-red-100 text-red-700 border border-red-400 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    {{-- ---------------------------------------- Current uploaded PDF that exist ------------------------ --}}
                    @if ($template)
                        <div class="mt-0 container border border-gray-300 p-4 bg-white rounded">
                            <h3 class="font-semibold">Current Template:</h3>
                            <a href="{{ route('proposal.template.download') }}" class="text-blue-600 hover:underline">
                                {{ $template->file_name }}
                            </a>
                        </div>
                    @else
                        <p class="mt-4 text-gray-600">No template uploaded yet.</p>
                    @endif

                    {{-- -------------------------------------- Upload form -------------------------------------------- --}}
                    <form action="{{ route('club.request.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <label class="block mb-2 font-semibold flex justify-between items-center">
                            <span>Upload New Proposal Template (PDF):</span>

                            <!-- Tooltip Icon -->
                            <span class="relative group cursor-pointer">
                                <span
                                    class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm">?</span>

                                <!-- Tooltip Box -->
                                <span
                                    class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 w-56 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg">
                                    Upload a new PDF club proposal template that students can download as a guide. Uploading
                                    again will
                                    replace the existing file.
                                </span>
                            </span>
                        </label>
                        &nbsp;
                        <input type="file" name="template_pdf" accept="application/pdf" required
                            class="border p-2 w-full mb-4 rounded">
                        <button type="submit"
                            class="px-4 py-2 {{ $template ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-blue-600 hover:bg-blue-700' }} text-white rounded">
                            {{ $template ? 'Edit Template' : 'Upload Template' }}
                        </button>

                        <a href="{{ route('club.index') }}"
                            class="ml-4 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                            Back to Club Page
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

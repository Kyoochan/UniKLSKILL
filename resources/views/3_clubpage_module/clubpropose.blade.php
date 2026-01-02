@extends('layoutStyle.styling')
{{-- student propose new club for admin to approve + student can view all submitted proposal --}}
@section('content')
    <div class="flex flex-col items-center gap-8 mb-10">
        <div x-data="{ tab: 'tab1' }"
            class="w-full max-w-5xl mx-auto mt-8 bg-gradient-to-br from-white via-gray-50 to-gray-100
           rounded-2xl shadow-xl p-6 border border-gray-200">

            <!-- Tabs -->
            <div class="flex border-b mb-6 space-x-2">
                <button @click="tab = 'tab1'"
                    :class="tab === 'tab1' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Propose New Club
                </button>

                <button @click="tab = 'tab2'"
                    :class="tab === 'tab2' ? 'bg-orange-600 text-white shadow-md' : 'text-gray-600 hover:bg-orange-100'"
                    class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                    Submitted Club Proposal
                </button>
            </div>

            <!-- Tab Content -->
            <div class="mt-1 mb-4 px-6 ">
                <!-- Tab 1 Content -->
                <div x-show="tab === 'tab1'" x-cloak x-transition>
                    <div class="px-15 bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold mb-6 text-center">Propose a New Club</h2>

                        {{-- Error Message --}}
                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @php
                            // Check if the user already has a pending proposal
                            $hasPendingProposal = $proposals->contains('status', 'pending');
                        @endphp

                        <form action="{{ route('club.propose.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="clubname" class="block text-gray-700 font-bold mb-2">Club Name</label>
                                <input type="text" name="clubname" id="clubname" placeholder="Insert club's name..."
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    {{ $hasPendingProposal ? 'disabled' : '' }} required>
                            </div>

                            <div class="mb-4">
                                <label for="clubdesc" class="block text-gray-700 font-bold mb-2">Description</label>
                                <textarea name="clubdesc" id="clubdesc" placeholder="Insert club's description..."
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    rows="4" {{ $hasPendingProposal ? 'disabled' : '' }} required></textarea>
                            </div>

                            <div>
                                <label class="block text-gray-700 font-bold mb-2 flex justify-between items-center">
                                    <span>Club Proposal PDF:</span>

                                    <!-- Tooltip Icon -->
                                    <span class="relative group cursor-pointer">
                                        <span
                                            class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm">?</span>

                                        <!-- Tooltip Box -->
                                        <span
                                            class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-6 w-56 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg">
                                            Download the proposal template to guide you in preparing your club proposal.
                                        </span>
                                    </span>
                                </label>
                            </div>

                            <div class="mt-6 container border border-grey p-4 bg-white rounded">
                                <a href="{{ route('proposal.template.download') }}"
                                    class="text-blue-600 hover:underline font-medium">
                                    Download Proposal Template
                                </a>
                            </div>
                            &nbsp;

                            <div class="mb-4">
                                <label for="proposal_pdf" class="block text-gray-700 font-bold mb-2">Proposal (PDF)</label>
                                <input type="file" name="proposal_pdf" id="proposal_pdf" accept="application/pdf"
                                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                                    {{ $hasPendingProposal ? 'disabled' : '' }} required>
                            </div>
                            &nbsp;

                            <div class="flex justify-right ">
                                @if ($hasPendingProposal)
                                    <button type="button"
                                        class="px-4 py-2 bg-gray-400 text-white rounded cursor-not-allowed opacity-75">
                                        Waiting for Approval
                                    </button>
                                @else
                                    <button type="submit"
                                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                                        Submit Proposal
                                    </button>
                                @endif
                                <a href="{{ route('club.index') }}"
                                    class="mx-2 px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                                    Back to Club Main Page
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- Tab 2 Content -->
                <div x-show="tab === 'tab2'" x-cloak x-transition>
                    {{-- ========================== STUDENT’S SUBMITTED PROPOSALS =========================== --}}

                    <div class="w-full bg-white p-6 rounded-lg shadow-md">

                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-bold text-center">My Submitted Proposals</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full border-collapse border border-gray-300">
                                <thead class="bg-blue-700 text-white">
                                    <tr>
                                        <th class="text-center px-4 py-2 border-b font-bold">Club Name</th>
                                        <th class="text-center px-4 py-2 border-b font-bold">Status</th>
                                        <th class="text-center px-4 py-2 border-b font-bold">Date submitted</th>
                                        <th class="text-center px-4 py-2 border-b font-bold">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($proposals as $proposal)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="border px-4 py-2">{{ $proposal->clubname }}</td>

                                            <td class="border px-4 py-2">
                                                @if ($proposal->status === 'approved')
                                                    <span class="text-green-600 font-medium">Approved</span>
                                                @elseif ($proposal->status === 'rejected')
                                                    <span class="text-red-600 font-medium">Rejected</span>
                                                @else
                                                    <span class="text-yellow-500 font-medium">Pending</span>
                                                @endif
                                            </td>

                                            <td class="border p-2">
                                                {{ \Carbon\Carbon::parse($proposal->created_at)->format('d M Y') }}
                                            </td>
                                            <td class="border px-4 py-2">
                                                {{ $proposal->remarks ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-gray-500 py-4">
                                                No proposals submitted yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="flex justify-left mt-8 gap-4">

                            <a href="{{ route('club.index') }}"
                                class="mx-2 px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                                Back to Club Main Page
                            </a>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        {{-- ========================== PROPOSE NEW CLUB FORM =========================== --}}





    </div>

    {{-- ======================== SIMPLE JS TOGGLE SCRIPT========================== --}}
    <script>
        const toggleBtn = document.getElementById('toggleTableBtn');
        const table = document.getElementById('proposalTable');
        const text = document.getElementById('toggleText');
        const icon = document.getElementById('toggleIcon');

        toggleBtn.addEventListener('click', () => {
            table.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
            text.textContent = table.classList.contains('hidden') ? 'Show' : 'Hide';
        });
    </script>
@endsection

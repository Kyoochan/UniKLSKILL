<div>
    {{-- ---------------------------------- Search bar ----------------------------------- --}}
    <div class="mb-6 flex justify-center">
        <input wire:model.defer="search" wire:keydown.enter="searchClubs" type="text"
            placeholder="Search the name of the club you wish to find..."
            class="border px-3 py-2 mb-2 rounded w-1/2 border-gray-400 hover:border-orange-500 hover:border-1 hover:bg-gray-50 px-20">
        <button wire:click="searchClubs" class="ml-3 bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
            Search
        </button>
    </div>

    {{-- -------------------------------- Club Grid ------------------------------- --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($clubs as $club)
            <div
                class="border rounded-lg shadow hover:shadow-lg transition bg-white overflow-hidden flex flex-col h-full">
                {{-- Banner --}}
                @if ($club->banner_image)
                    <img src="{{ asset('storage/' . $club->banner_image) }}" alt="{{ $club->clubname }} Banner"
                        class="w-full h-40 object-cover">
                @else
                    <div class="w-full h-40 bg-gray-200 flex items-center justify-center text-gray-500">
                        No Banner
                    </div>
                @endif
                {{-- Club Info --}}
                <div class="p-4 flex flex-col flex-grow">
                    <h2 class="text-xl font-bold mb-2 line-clamp-1">{{ $club->clubname }}</h2>
                    <p class="text-gray-600 mb-4 line-clamp-3 flex-grow">
                       {{ Str::limit($club->clubdesc, 150) }}
                    </p>


                    {{-- Advisor Tag (visible only to assigned advisor) --}}
                    @if (Auth::check() && Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::user()->id)
                        <div class="mb-3">
                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                You are assigned here as the club Advisor
                            </span>
                        </div>
                    @elseif(Auth::check() && Auth::user()->userRole === 'admin' && $club->advisor)
                        {{-- For admin view, still show assigned advisor --}}
                        <div class="mb-3">
                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                                Current Advisor : {{ $club->advisor->name }}
                            </span>
                        </div>
                    @elseif(Auth::check() && $club->members()->where('user_id', Auth::id())->wherePivot('position', 'high_committee')->exists())
                        <div class="mb-3">
                            <span
                                class="inline-block bg-orange-100 text-orange-800 text-sm font-medium px-3 py-1 rounded-full">
                                High Committee :
                                {{ $club->members()->where('user_id', Auth::id())->first()->pivot->role }}
                            </span>
                        </div>
                    @endif

                    {{-- Footer Buttons --}}
                    <div class="mt-auto pt-3 border-t flex gap-2">
                        <a href="{{ route('club.show', $club->id) }}"
                            class="flex-1 text-center px-4 py-2 bg-orange-600 text-white rounded hover:bg-orange-700 transition">
                            View
                        </a>

                        @auth
                            @if (Auth::user()->userRole === 'admin')
                                <a href="{{ route('club.edit', $club->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('club.destroy', $club->id) }}"
                                    onsubmit="return confirm('Delete this club?')" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            @elseif (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id())
                                <a href="{{ route('club.edit', $club->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                            @elseif (Auth::check() && $club->members()->where('user_id', Auth::id())->wherePivot('position', 'high_committee')->exists())
                                <a href="{{ route('club.edit', $club->id) }}"
                                    class="flex-1 text-center px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition">
                                    Edit
                                </a>
                            @elseif (Auth::user()->userRole === 'student')
                                @php
                                    $pendingRequest = $club->joinRequests
                                        ->where('user_id', Auth::id())
                                        ->where('status', 'pending')
                                        ->first();
                                @endphp

                                @if ($club->members->contains(Auth::id()))
                                    {{-- Already a member, no button --}}
                                @elseif($pendingRequest)
                                    <button type="button"
                                        class="inline-block px-5 py-2 bg-yellow-400 text-white rounded-lg cursor-not-allowed">
                                        Waiting for Approval
                                    </button>
                                @else
                                    <form action="{{ route('club.join', $club->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-block px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                            Request Join Club
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endauth
                    </div>

                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">No clubs found.</p>
        @endforelse
    </div>
</div>

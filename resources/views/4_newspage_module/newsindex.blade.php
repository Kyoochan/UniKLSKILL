@extends('layoutStyle.styling')

<!-- Display all news/non club activity = main News page -->

@section('content')
    <!-- Latest News Section -->
    <div class="mt-10 bg-white p-6 rounded-lg mx-8">
        <div class="grid grid-cols-1 lg:grid-cols-3  border-3 border-orange-400 rounded-lg">

            <!-- ========== FEATURED NEWS (LEFT SIDE) ========== -->
            @if ($latestNews->count() > 0)
                @php
                    $featured = $latestNews->first();
                @endphp

                <a href="{{ route('news.show', $featured->id) }}"
                    class="lg:col-span-2 bg-white block hover:bg-gray-100 rounded-xl px-12 p-4 transition">

                    <!-- Title -->
                    <h3 class="text-3xl font-bold text-gray-900 leading-tight mb-4 mt-4 border-b">
                        {{ $featured->news_name }}
                    </h3>

                    <!-- Image -->
                    @if ($featured->image)
                        <img src="{{ asset('storage/' . $featured->image) }}"
                            class="rounded-xl w-full max-h-[450px] object-cover shadow">
                    @endif

                    <!-- Category -->
                    <div class="flex items-center space-x-4 text-sm text-gray-500 mb-4 mt-4">
                        <span class="text-orange-600 font-semibold">
                            {{ $featured->dna_category ? 'GHOCS Claimable' : 'News' }}
                        </span>
                    </div>

                    <!-- Description -->
                    <h3 class="text-sm text-gray-600 line-clamp-2 mt-1">
                        {{ Str::limit($featured->news_description, 80) }}
                    </h3>

                </a>
            @endif


            <!-- ========== SIDE NEWS LIST (RIGHT SIDE) ========== -->
            <div class="bg-white p-6 rounded-lg shadow-lg">

                <!-- Header -->
                <h3 class="text-4xl font-bold text-gray-800 mb-4 border-b pb-2 text-center ">
                    Recent Post
                </h3>

                <div class="space-y-6">
                    @foreach ($latestNews->skip(1)->take(4) as $item)
                        <a href="{{ route('news.show', $item->id) }}"
                            class="flex items-start space-x-4 hover:bg-gray-100 p-2 rounded-lg transition border-b">

                            <!-- Thumbnail -->
                            @if ($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    class="w-32 h-24 rounded-lg object-cover shadow">
                            @else
                                <div class="w-32 h-24 bg-gray-300 rounded-lg"></div>
                            @endif

                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-900 line-clamp-2">
                                    {{ $item->news_name }}
                                </h4>

                                <p class="text-sm text-gray-600 line-clamp-2 mt-1">
                                    {{ Str::limit($item->news_description, 40) }}
                                </p>

                                <div class="text-sm text-gray-500 flex items-center space-x-2 mt-2">
                                    <span class="text-orange-600 font-semibold">
                                        {{ $item->dna_category ? 'GHOCS Claimable' : 'News' }}
                                    </span>
                                </div>
                            </div>

                        </a>
                    @endforeach
                </div>

            </div>

        </div>
    </div>

    <!-- Bottom side + search bar + view news section -->
    <div class="flex gap-x-6  mb-10 mt-10">
        <div class="w-8/12 bg-white p-6 rounded-lg ms-8">

            <h1 class="text-4xl font-bold mb-4 mt-10 text-center">Discover Latest UniKL MIIT News or Event</h1>

            <p class="text-1xl font-semibold mb-4 text-gray-600 text-center mt-10 mb-10 px-15">Stay updated with news
                regarding
                UniKL MIIT
                efforts to be the best as an
                institute. Support your fellow colleagues and stay alert of any non-club activities that you can claim its
                GHOCS to improve your transcripts.</p>

            <form method="GET" action="{{ route('news.index') }}" class="flex items-center gap-2 px-20">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search news..."
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:border-1 hover:bg-gray-50">
                <!-- Search Button -->
                <button class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded">
                    Search
                </button>

                {{-- Clear Button --}}
                @if (request('search'))
                    <a href="{{ route('news.index') }}" class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded">
                        Clear
                    </a>
                @endif
            </form>

            <div class="mt-6 space-y-6">
                @forelse ($news as $item)
                    <div class="border rounded-lg p-4 shadow-sm flex flex-col justify-between">

                        {{-- Header --}}
                        <div class="flex justify-between items-center border-b pb-2 mb-3">
                            <h3 class="text-xl font-bold text-gray-800 px-4">{{ $item->news_name }}</h3>
                            <p class="text-sm text-gray-500">
                                {{ $item->created_at->format('M d, Y') }}
                            </p>
                        </div>



                        {{-- Body --}}
                        <div>
                            <div class="text-center">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}"
                                        class="mt-3 mx-auto w-full max-w-md rounded-lg shadow-md">
                                @endif
                            </div>

                            {{-- Badges --}}
                            <div class="flex items-center space-x-2 p-4 border-b border-gray-100">

                                {{-- Level --}}
                                <div class="relative group">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-white rounded-lg
                            @if ($item->level) bg-red-500 @endif">
                                        {{ $item->level }}
                                    </span>

                                    <div
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        Activity Level
                                    </div>
                                </div>

                                {{-- DNA Category --}}
                                <div class="relative group">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-white rounded-lg
                            @if ($item->dna_category) bg-orange-500 @endif">
                                        {{ $item->dna_category }}
                                    </span>
                                    <div
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        DNA Category
                                    </div>
                                </div>

                                {{-- GHOCS --}}
                                <div class="relative group">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold text-white rounded-lg
                            @if ($item->ghocs_element) bg-yellow-500 @endif">
                                        {{ $item->ghocs_element }}
                                    </span>
                                    <div
                                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        SPICES Domain
                                    </div>
                                </div>
                            </div>

                            <p class="text-sm text-gray-500 mb-1 px-4">By {{ $item->author ?? 'Unknown' }}</p>
                            <p class="text-gray-600 mt-2 -mb-2 px-5">{{ Str::limit($item->news_description, 150) }}</p>
                        </div>

                        {{-- View Button --}}
                        <div class="mt-4 border-t pt-3 flex justify-center items-center gap-4 py-2">
                            <!-- View Button -->
                            <a href="{{ route('news.show', $item->id) }}"
                                class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg shadow transition">
                                View
                            </a>

                            @auth
                                @if (auth()->user()->userRole === 'admin')
                                    <!-- Delete Button -->
                                    <form action="{{ route('news.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this news?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg shadow">
                                            Delete
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>

                    </div>

                @empty
                    <p class="text-gray-500 text-center">No news posted yet.</p>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $news->links('pagination::tailwind') }}
                </div>
            </div>
        </div>

        {{--  Manage/request to advertise non club activity section on right --}}
        @auth
            @if (Auth::user()->userRole === 'admin')
                <div class="w-5/18 bg-white p-6 rounded-lg shadow h-64">
                    <h2 class="text-2xl font-semibold mb-4">Manage News Request</h2>

                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('news.create') }}"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow">
                            Manage News
                        </a>
                        <a href="{{ route('proposalnews.manage') }}"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow">
                            Manage Non-Club Activity Proposals
                        </a>
                    </div>
                </div>
            @elseif (Auth::user()->userRole === 'student' || Auth::user()->userRole === 'advisor')
                <div class="w-5/18 bg-white p-6 rounded-lg shadow h-64">
                    <h2 class="text-2xl font-semibold mb-4 text-center flex items-center justify-center gap-2">
                        Activity Advertising

                        <!-- Tooltip Wrapper -->
                        <div class="relative group">
                            <!-- Question Mark Icon -->
                            <span class="text-orange-500 cursor-pointer text-bold">?</span>

                            <!-- Tooltip -->
                            <div
                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-48 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 text-center">
                                If you have non-club activity that is GHOCS claimable or important news, you can request for
                                SDCL to upload here.
                            </div>
                        </div>
                    </h2>
                    <a href="{{ route('proposalnews.create') }}"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow mb-4 inline-block">
                        Propose Non-Club Activity
                    </a>
                </div>
            @endif

        @endauth


    </div>

@endsection

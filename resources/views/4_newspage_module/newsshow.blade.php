@extends('layoutStyle.styling')
{{-- Users click view news from the news main page --}}
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow mt-10 mb-10">

        {{-- 🔹 Title + Date Header --}}
        <div class="flex justify-between items-center border-b pb-3 mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $news->news_name }}</h1>
            <p class="text-sm text-gray-500">
                {{ $news->created_at->format('F d, Y h:i A') }}
            </p>
        </div>

        {{-- 🔹 Image Section --}}
        @if ($news->image)
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $news->image) }}" alt="News Image"
                    class="rounded-lg shadow w-full max-w-3xl object-contain">
            </div>
        @endif

        {{-- 🔹 Badges --}}
        <div class="flex flex-wrap items-center gap-2 mb-6">

            {{-- Level Badge --}}
            <div class="relative group">
                <span
                    class="px-2 py-1 text-xs font-semibold text-white rounded-full
                    @if ($news->level === 'Campus Level') bg-red-500
                    @elseif($news->level === 'University Level') bg-red-500
                    @elseif($news->level === 'National Level') bg-red-500
                    @elseif($news->level === 'International Level') bg-red-500
                    @else bg-white @endif">
                    {{ $news->level ?? '' }}
                </span>
                <div
                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    Activity Level
                </div>
            </div>

            {{-- Category Badge --}}
            <div class="relative group">
                <span
                    class="px-2 py-1 text-xs font-semibold text-white rounded-full
                    @if ($news->dna_category === 'Active Programme') bg-orange-500
                    @elseif($news->dna_category === 'Sports & Recreation') bg-orange-500
                    @elseif($news->dna_category === 'Entrepreneur') bg-orange-500
                    @elseif($news->dna_category === 'Global') bg-orange-500
                    @elseif($news->dna_category === 'Graduate') bg-orange-500
                    @elseif($news->dna_category === 'Leadership') bg-orange-500
                    @else bg-white @endif">
                    {{ $news->dna_category ?? '' }}
                </span>
                <div
                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    DNA Category
                </div>
            </div>

            {{-- Priority / GHOCS Badge --}}
            <div class="relative group">
                <span
                    class="px-2 py-1 text-xs font-semibold text-white rounded-full
                    @if ($news->ghocs_element === 'Spiritual') bg-yellow-500
                    @elseif($news->ghocs_element === 'Physical') bg-yellow-500
                    @elseif($news->ghocs_element === 'Intellectual') bg-yellow-500
                    @elseif($news->ghocs_element === 'Career') bg-yellow-500
                    @elseif($news->ghocs_element === 'Emotional') bg-yellow-500
                    @elseif($news->ghocs_element === 'Social') bg-yellow-500
                    @else bg-white @endif">
                    {{ $news->ghocs_element ?? '' }}
                </span>
                <div
                    class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                    GHOCS Domain
                </div>
            </div>

        </div>

        {{-- 🔹 Description --}}
        <p class="text-gray-700 mb-6 leading-relaxed text-justify border-1 px-2 py-2 rounded-lg">
            {{ $news->news_description }}
        </p>

        {{-- 🔹 Footer --}}
        <div class="text-left mt-8">
            <a href="{{ route('news.index') }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
                Back to News
            </a>
        </div>
    </div>
@endsection

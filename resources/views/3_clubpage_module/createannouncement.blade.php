@extends('layoutStyle.styling')
{{-- High Com/Club advisor post announcement on club page --}}
@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-8 mb-10">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Create Club Announcement</h1>

        <!-- Display validation errors -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('announcements.store', $club->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Announcement Title</label>
                <input type="text" name="title" value="{{ old('title') }}" placeholder="Insert announcement title..."
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea name="content" rows="5" placeholder="Insert announcement description..."
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none"
                    required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-semibold mb-2">Attachment (Image)</label>
                <input type="file" name="attachment" accept="image/*"
                    class="border px-3 py-2 mb-2 rounded w-full border-gray-400 hover:border-orange-500 hover:bg-gray-50
                           focus:border-2 focus:border-orange-500 focus:outline-none">
                @error('attachment')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                    Post Announcement
                </button>
            </div>
            <div class="flex justify-right mt-10">
                <a href="{{ route('club.show', $club->id) }}"
                    class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Back to {{ $club->clubname }} Page
                </a>
            </div>
        </form>
    </div>
@endsection

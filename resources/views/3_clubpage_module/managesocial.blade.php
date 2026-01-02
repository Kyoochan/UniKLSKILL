@extends('layoutStyle.styling')
{{-- Club managing and sharing social media link/alternatives --}}
@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 shadow rounded-lg mt-10 mb-10">
        <h1 class="text-2xl font-semibold text-black mb-6 text-center">
            Manage Social Media for {{ $club->clubname }}
        </h1>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Add Social Media Form --}}
        <div class="max-w-4xl mx-auto bg-white p-8 shadow border-2 rounded-lg mt-10 mb-10">

            <div class="text-1xl font-semibold text-black mb-6 text-center">
                Add Social Media Platform for {{ $club->clubname }}
            </div>

            <form action="{{ route('club.socials.store', $club->id) }}" method="POST" class="space-y-4 mb-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="name" placeholder="Social Media Name (Facebook, Twitter, etc.)"
                        class="border rounded p-2 w-full focus:ring-orange-400 focus:border-orange-400"
                        value="{{ old('name') }}" required>
                    <input type="url" name="link" placeholder="Social Media Link (URL)"
                        class="border rounded p-2 w-full focus:ring-orange-400 focus:border-orange-400"
                        value="{{ old('link') }}" required>
                </div>
                <div class="text-center mt-10">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded shadow">
                        Add Social Media
                    </button>
                </div>
            </form>
        </div>

        {{-- List Existing Socials --}}

        <h2 class="text-2xl font-semibold text-black mb-6 text-center">
            Current Social Media for {{ $club->clubname }}
        </h2>
        <table class="min-w-full border border-black overflow-hidden">
            <thead class="bg-orange-500 text-white text-center font-bold">
                <tr>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($socials as $social)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 font-medium">{{ $social->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ $social->link }}" target="_blank"
                                class="text-blue-600 hover:underline">{{ $social->link }}</a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <form action="{{ route('club.socials.destroy', [$club->id, $social->id]) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete this social link?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">
                            No social media links added yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Back to Club Page --}}
        <div class="mt-6 text-center">
            <a href="{{ route('club.show', $club->id) }}"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                Back to {{ $club->clubname }} Page
            </a>
        </div>
    </div>
@endsection

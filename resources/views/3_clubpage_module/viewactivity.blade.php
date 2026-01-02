@extends('layoutStyle.styling')
{{-- view approved activity on club main page --}}
@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-xl mt-6 mb-10">
        {{-- Header --}}
        <div class="border-b pb-4 mb-4 flex justify-between items-center">
            <h1 class="text-black font-bold text-2xl -ml-px">{{ $activity->activity_title }}</h1>
            <p class="text-sm text-gray-500">{{ $activity->posted_at->format('d M Y, h:i A') }}</p>
        </div>

        {{-- Images --}}
        @if (!empty($activity->images))
            @php
                $images = is_array($activity->images) ? $activity->images : json_decode($activity->images, true);
            @endphp

            @if (is_array($images))
                <div
                    class="@if (count($images) === 1) flex justify-center
                                        @else grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center @endif
                                        mx-auto max-w-6xl w-full">
                    @foreach ($images as $img)
                        <div class="flex justify-center w-full">
                            <img src="{{ asset('storage/' . $img) }}"
                                class="shadow-lg w-full max-w-3xl h-auto object-cover rounded-lg" alt="Activity Image">
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-sm mt-2 text-center">Image data invalid</p>
            @endif
        @endif

        {{-- Dates and Badges --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-2 mb-4 gap-4">
            {{-- Badges --}}
            <div class="flex flex-wrap items-center gap-2">

                {{-- Level Badge --}}
                <div class="relative group">
                    <span
                        class="px-2 py-1 text-xs font-semibold text-white rounded-full
            @if ($activity->level === 'Campus Level') bg-red-500
            @elseif($activity->level === 'University Level') bg-red-500
            @elseif($activity->level === 'National Level') bg-red-500
            @elseif($activity->level === 'International Level') bg-red-500
            @else bg-gray-500 @endif">
                        {{ $activity->level ?? 'N/A' }}
                    </span>
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        Activity Level
                    </div>
                </div>

                {{-- DNA Category Badge --}}
                <div class="relative group">
                    <span
                        class="px-2 py-1 text-xs font-semibold text-white rounded-full
            @if ($activity->dna_category === 'Knowledge') bg-orange-500
            @elseif($activity->dna_category === 'Sports & Recreation') bg-orange-500
            @elseif($activity->dna_category === 'Entrepreneur') bg-orange-500
            @elseif($activity->dna_category === 'Global') bg-orange-500
            @elseif($activity->dna_category === 'Graduate') bg-orange-500
            @elseif($activity->dna_category === 'Leadership') bg-orange-500
            @else bg-gray-500 @endif">
                        {{ $activity->dna_category ?? 'N/A' }}
                    </span>
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        DNA Category
                    </div>
                </div>

                {{-- GHOCS Domain Badge --}}
                <div class="relative group">
                    <span
                        class="px-2 py-1 text-xs font-semibold text-white rounded-full
            @if ($activity->ghocs_element === 'Spiritual') bg-yellow-500
            @elseif($activity->ghocs_element === 'Physical') bg-yellow-500
            @elseif($activity->ghocs_element === 'Intellectual') bg-yellow-500
            @elseif($activity->ghocs_element === 'Career') bg-yellow-500
            @elseif($activity->ghocs_element === 'Emotional') bg-yellow-500
            @elseif($activity->ghocs_element === 'Social') bg-yellow-500
            @else bg-gray-400 @endif">
                        {{ $activity->ghocs_element ?? 'N/A' }}
                    </span>
                    <div
                        class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                        GHOCS Domain
                    </div>
                </div>

            </div>



        </div>

        {{-- Description --}}
        <div class="pt-4 text-gray-700 leading-relaxed mb-6 mt-4 space-y-3">

            <div>
                <p class="text-black font-bold text-2xl mb-2">Description</p>

                <p>{{ $activity->activity_description }}</p>
            </div>

            {{-- Activity Dates --}}
            <div class="text-gray-700 text-sm">
                <span class="font-semibold">Activity Start :</span>
                {{ $activity->activity_date }}
                @if ($activity->activity_date_end)
                    Until {{ $activity->activity_date_end }}
                @endif
            </div>

            {{-- Location --}}
            <div class="text-gray-700 text-sm">
                <span class="font-semibold">Location:</span> {{ $activity->location ?? 'N/A' }}
            </div>
        </div>



        {{-- Discussion Section --}}
        <div class="border-t pt-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Activity Discussion</h2>

            {{-- Chatbox Container --}}
            <div class="bg-gray-50 rounded-lg shadow-inner p-4 h-96 overflow-y-auto space-y-4 mb-4">
                @forelse ($activity->comments as $comment)
                    <div class="flex items-start space-x-3">
                        {{-- Avatar --}}
                        <div
                            class="w-10 h-10 rounded-full bg-orange-400 flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                        </div>

                        {{-- Comment Bubble --}}
                        <div class="flex-1 bg-white p-3 rounded-lg shadow-sm">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-semibold text-gray-800">{{ $comment->user->name }}</span>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 mb-2">{{ $comment->comment }}</p>

                            @if ($comment->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $comment->image) }}" alt="Attached Image"
                                        class="rounded-lg max-h-48 object-cover cursor-pointer transition hover:opacity-90">
                                </div>
                            @endif

                            {{-- Comment Delete button --}}
                            @php
                                $isHighCommittee = $club->members->contains(function ($member) {
                                    return $member->id === Auth::id() && $member->pivot->position === 'high_committee';
                                });
                            @endphp

                            @if ((Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) || $isHighCommittee)
                                <form action="{{ route('activity.comment.destroy', $comment->id) }}" method="POST"
                                    class="mt-2 flex justify-end">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-700 text-sm font-medium transition"
                                        onclick="return confirm('Are you sure you want to delete this comment?')">
                                        Delete
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No comments yet.</p>
                @endforelse
            </div>

            {{-- Comment Form --}}
            @auth
                <form action="{{ route('activity.comment.store', $activity->id) }}" method="POST"
                    enctype="multipart/form-data"
                    class="bg-white p-4 rounded-lg shadow flex flex-col sm:flex-row sm:items-end gap-3 sticky bottom-0">
                    @csrf

                    <div class="flex-1">
                        <textarea name="comment" rows="2" required
                            class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-orange-500 focus:outline-none"
                            placeholder="Type your message..."></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <input type="file" name="image" accept="image/*"
                            class="text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer px-2 py-1 focus:ring-2 focus:ring-orange-400">

                        <button type="submit"
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
                            Send
                        </button>
                    </div>
                </form>
            @endauth
        </div>



        {{-- Back Button --}}
        <div class="pt-6 mt-6 text-left">
            <a href="{{ route('club.show', $club->id) }}"
                class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg shadow transition">
                Back to Club Page
            </a>
        </div>
    </div>
@endsection

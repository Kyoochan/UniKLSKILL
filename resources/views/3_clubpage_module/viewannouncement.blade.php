@extends('layoutStyle.styling')
{{-- view posted announcement on club page --}}
@section('content')
    <div class="max-w-5xl mx-auto p-6 bg-white shadow-md rounded-xl mt-6 mb-10">
        {{-- Header --}}
        <div class="border-b pb-4 mb-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-800">{{ $announcement->title }}</h1>
            <p class="text-sm text-gray-500">{{ $announcement->created_at->format('d M Y, h:i A') }}</p>
        </div>

        {{-- Attachment (Optional) --}}
        @if ($announcement->attachment)
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $announcement->attachment) }}" alt="Announcement Attachment"
                    class="w-full max-w-3xl mx-auto rounded-lg shadow-md">
            </div>
        @endif

        {{-- Description / Content --}}
        <div class="pt-4 text-gray-700 leading-relaxed mb-6 mt-4">
            <p class="text-black font-bold text-2xl -ml-px">Description</p>
            {{ $announcement->content }}
        </div>

        {{-- Discussion Section --}}
        <div class="border-t pt-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Announcement Discussion</h2>

            {{-- 💬 Chatbox Container --}}
            <div class="bg-gray-50 rounded-lg shadow-inner p-4 h-96 overflow-y-auto space-y-4 mb-4">
                @forelse ($announcement->comments as $comment)
                    <div class="flex items-start space-x-3">
                        {{-- Avatar --}}
                        <div
                            class="w-10 h-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold">
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
                                <form action="{{ route('announcement.comment.destroy', $comment->id) }}" method="POST"
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

            {{-- ✍️ Comment Form --}}
            @auth
                <form action="{{ route('announcement.comment.store', $announcement->id) }}" method="POST"
                    enctype="multipart/form-data"
                    class="bg-white p-4 rounded-lg shadow flex flex-col sm:flex-row sm:items-end gap-3 sticky bottom-0">
                    @csrf

                    <div class="flex-1">
                        <textarea name="comment" rows="2" required
                            class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Type your message..."></textarea>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <input type="file" name="image" accept="image/*"
                            class="text-sm text-gray-600 border border-gray-300 rounded-lg cursor-pointer px-2 py-1 focus:ring-2 focus:ring-blue-400">

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
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
                Back to {{ $club->clubname }} Page
            </a>
        </div>
    </div>
@endsection

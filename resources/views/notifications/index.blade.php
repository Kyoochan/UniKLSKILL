@extends('layoutStyle.styling')

@section('content')
    <div class="w-10/12 bg-white p-6 rounded-lg shadow-md flex flex-col gap-8 mx-auto">

        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">All Notifications</h1>
            @if ($notifications->count() > 0)
                <form action="{{ route('notifications.destroyAll') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                        Clear All
                    </button>
                </form>
            @endif
        </div>

        <ul class="space-y-2">
            @forelse($notifications as $notif)
                <li
                    class="p-3 border rounded flex justify-between items-start @if (!$notif->is_read) bg-gray-100 @endif">
                    <div>
                        {{ $notif->message }}
                        <span class="text-xs text-gray-400 block">{{ $notif->created_at->diffForHumans() }}</span>
                    </div>
                    <form action="{{ route('notifications.destroy', $notif->id) }}" method="POST" class="ml-4">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </li>
            @empty
                <li class="text-gray-500">You have no notifications.</li>
            @endforelse
        </ul>

        {{-- ✅ Pagination Section --}}
        @if ($notifications->hasPages() || $notifications->count() > 0)
            <div class="flex flex-col items-center mt-6 text-sm text-gray-600">

                {{-- Pagination links (arrows) --}}
                <div class="notification-pagination">
                    {!! $notifications->onEachSide(1)->links() !!}
                </div>

                {{-- Page info BELOW the arrows --}}
                <div class="mt-2">
                    Showing page
                    <span class="font-semibold">{{ $notifications->currentPage() }}</span>
                    of
                    <span class="font-semibold">{{ $notifications->lastPage() }}</span>
                </div>

            </div>
        @endif


    </div>
@endsection
<style>
/* Make the 'Showing X to Y of Z results' text white and unselectable */
.notification-pagination nav[role="navigation"] p.text-sm.text-gray-700.leading-5,
.notification-pagination nav[role="navigation"] p.text-sm.text-gray-500.leading-5,
.notification-pagination nav[role="navigation"] p {
    color: white !important;
    user-select: none !important; /* Prevent text selection */
    pointer-events: none !important; /* Disable any mouse interaction */


}
</style>

<style>
.notification-pagination {
    transform: translateX(-80px); /* move left slightly */
}
</style>

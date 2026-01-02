<div class="relative">
    <button wire:click="$toggle('open')" class="relative">
        <svg ...> <!-- bell icon --> </svg>
        @if(count($notifications) > 0)
            <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full"></span>
        @endif
    </button>

    <div x-show="open" class="absolute right-0 mt-2 w-80 bg-white border rounded shadow-lg">
        <h3 class="font-semibold px-4 py-2 border-b">Notifications</h3>
        <ul class="max-h-60 overflow-y-auto">
            @forelse($notifications as $notif)
                <li class="px-4 py-2 border-b bg-gray-100">
                    {{ $notif['message'] }}
                    <span class="text-xs text-gray-400 block">{{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}</span>
                </li>
            @empty
                <li class="px-4 py-2 text-gray-500">No notifications</li>
            @endforelse
        </ul>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniKLSKILL | </title>

    @livewireStyles

    @vite('resources/css/app.css')
</head>

<body class="bg-gray-200">

    <!-- Navigation Bar -->
    <nav class="p-3 bg-white flex justify-between mb-0 fixed top-0 left-0 w-full z-500 shadow">
        <ul class="flex items-center space-x-6">
            <img src="{{ asset('images/Logo.png') }}" alt="UniKL Logo" class="h-8">
        </ul>

        <ul class="flex items-center space-x-6">
            <x-hover-nav href="/home" :active="request()->is('home')">Home</x-hover-nav>
            <x-hover-nav href="/club" :active="request()->is('club')">Clubs</x-hover-nav>
            <x-hover-nav href="/news" :active="request()->is('news')">News</x-hover-nav>

            {{-- Show only for Student --}}
            @if (
                (Auth::check() && Auth::user()->userRole === 'student') ||
                    (Auth::check() && Auth::user()->userRole === 'secretary'))
                <x-hover-nav href="/curriculum" :active="request()->is('curriculum')">GHOCS</x-hover-nav>
            @endif

            <x-hover-nav href="/faq" :active="request()->is('faq')">FAQ</x-hover-nav>

            {{-- Show only for Admin --}}
            @if (Auth::check() && Auth::user()->userRole === 'admin')
                <x-hover-nav href="{{ route('staffaccount') }}" :active="request()->is('staffaccount')">Staff Account</x-hover-nav>
            @endif
        </ul>

        <ul class="flex items-center space-x-6 relative">
            @auth
                {{-- Notification Bell --}}
                @php
                    $notifications = Auth::user()->notifications()->orderBy('created_at', 'desc')->take(5)->get();
                    $unreadCount = $notifications->where('is_read', false)->count();
                @endphp
                <li class="relative">
                    <button id="notifBtn" class="relative focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700 hover:text-gray-900"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V4a1 1 0 00-2 0v1.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        @if ($unreadCount > 0)
                            <span class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full"></span>
                        @endif
                    </button>
                    {{-- Dropdown --}}
                    <div id="notifDropdown"
                        class="hidden absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded shadow-lg z-50">
                        <h3 class="font-semibold px-4 py-2 border-b">Notifications</h3>
                        <ul class="max-h-60 overflow-y-auto">
                            @forelse($notifications as $notif)
                                <li class="px-4 py-2 border-b @if (!$notif->is_read) bg-gray-100 @endif">
                                    {{ $notif->message }}
                                    <span
                                        class="text-xs text-gray-400 block">{{ $notif->created_at->diffForHumans() }}</span>
                                </li>
                            @empty
                                <li class="px-4 py-2 text-gray-500">No notifications</li>
                            @endforelse
                        </ul>
                        {{-- View All Button --}}
                        <div class="border-t px-4 py-2 text-center">
                            <a href="{{ route('notifications.index') }}"
                                class="text-blue-600 hover:underline font-semibold">
                                View All
                            </a>
                        </div>
                    </div>

                </li>

                {{-- Welcome and Logout --}}
                <li class="font-semibold text-gray-700">
                    Welcome, {{ Auth::user()->name }}
                </li>
                <form action="{{ route('logout.perform') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Logout</button>
                </form>
            @else
                <x-hover-nav href="/login" :active="request()->is('login')">Login</x-hover-nav>
                <x-hover-nav href="/register" :active="request()->is('register')">Register</x-hover-nav>
            @endauth
        </ul>
    </nav>
    <div class="pt-18"></div>

    @include('components.alert')

    @yield('content')

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            const notifDot = notifBtn.querySelector('span'); // the red dot

            notifBtn.addEventListener('click', function(event) {
                // Stop propagation to avoid closing immediately
                event.stopPropagation();

                // Toggle dropdown visibility
                notifDropdown.classList.toggle('hidden');

                // When opening dropdown: mark all as read via AJAX
                if (!notifDropdown.classList.contains('hidden')) {
                    fetch("{{ route('notifications.markAllReadAjax') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        }
                    }).then(() => {
                        // Remove the red dot after marking as read
                        if (notifDot) notifDot.remove();
                    });
                }
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!notifDropdown.classList.contains('hidden') &&
                    !notifDropdown.contains(event.target) &&
                    !notifBtn.contains(event.target)) {
                    notifDropdown.classList.add('hidden');
                }
            });
        });
    </script>

    {{-- ---------------------------------------------------- CHATBOT ----------------------------------------------------- --}}

    <!-- Include Alpine.js if not already -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <div x-data="{ open: false }">

        <!-- Floating Chatbot Button -->
        <div id="chatbotButton" @click="open = !open"
            class="fixed bottom-4 right-8    bg-orange-400 text-white w-20 h-20 rounded-full border-3 border-white shadow-2xl
     flex items-center justify-center shadow-xl cursor-pointer hover:bg-orange-500 z-50">

            <img src="/images/ChatbotImg.png" class="w-40 h-22 rotate-90" alt="Bot Icon">
        </div>

        <!-- Chatbot Box with Transition -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-75 translate-y-5"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-75 translate-y-5"
            class="fixed bottom-14 right-30 w-80 bg-white rounded-tl-lg rounded-tr-lg rounded-bl-lg
            rounded-br-none p-4 shadow-2xl border-4 border-orange-400 z-50">

            <h2 class="text-lg font-bold mb-2 text-center">FAQ Chatbot</h2>

            <div id="chatMessages" class="h-64 overflow-y-auto mb-3 p-2 bg-gray-100 rounded"></div>

            <form id="chatForm" class="flex">
                <input type="text" id="chatInput" placeholder="Say hi to chatbot!"
                    class="flex-1 border rounded-l px-3 py-2 focus:ring-2 focus:ring-orange-400">
                <button type="submit" class="bg-blue-600 text-white px-3 rounded-r hover:bg-blue-700">
                    Ask
                </button>
            </form>
        </div>
    </div>

    <style>
        #chatMessages::-webkit-scrollbar {
            width: 6px;
        }

        #chatMessages::-webkit-scrollbar-thumb {
            background: #cbd5e1;
        }
    </style>

    <script>
        // Handle chat form
        document.getElementById('chatForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            let input = document.getElementById('chatInput');
            let question = input.value.trim();
            if (!question) return;
            input.value = "";

            addMessage(question, "user"); // user bubble

            let response = await fetch("{{ route('faq.ask') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    question: question
                })
            });

            let data = await response.json();
            addMessage(data.response, "bot"); // bot bubble
        });

        // Function to add messages to chat box
        function addMessage(text, sender = "bot") {
            let box = document.getElementById('chatMessages');
            let msg = document.createElement("div");
            msg.className = "my-2 flex";

            if (sender === "user") {
                msg.innerHTML = `
                <div class="ml-auto bg-orange-400 text-white px-4 py-2 rounded-l-lg rounded-tr-lg max-w-xs break-words">
                    ${text}
                </div>
            `;
            } else {
                msg.innerHTML = `
                <div class="bg-gray-200 text-gray-900 px-4 py-2 rounded-r-lg rounded-tl-lg max-w-xs break-words">
                    ${text}
                </div>
            `;
            }

            box.appendChild(msg);
            box.scrollTop = box.scrollHeight;
        }
    </script>

    {{-- -------------------------------------------------- END CHATBOT ---------------------------------------------------- --}}
</body>

<footer>
    @include('layoutStyle.footer')
</footer>

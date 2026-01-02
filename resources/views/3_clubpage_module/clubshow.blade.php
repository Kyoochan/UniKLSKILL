@extends('layoutStyle.styling')
{{-- Users viewing details of each club (Social media,announcement,activities,contacts,member) --}}
@section('content')
    {{-- ---------------------------------- Club Info ---------------------------------- --}}
    <div class="max-w-7xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden mt-6">

        @if ($club->banner_image)
            <div class="w-full h-60 bg-gray-200">
                <img src="{{ asset('storage/' . $club->banner_image) }}" alt="Club Banner" class="w-full h-full object-cover">
            </div>
        @endif

        <div class="p-6 flex items-start space-x-6">
            @if ($club->profile_picture)
                <div class="w-62 h-62 flex-shrink-0 border-5 border-black -mt-21">
                    <img src="{{ asset('storage/' . $club->profile_picture) }}" alt="Club Profile"
                        class="w-60 h-60 square-full object-cover border -mt-0">
                </div>
            @endif

            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $club->clubname }}</h1>
                <p class="text-gray-700 mb-4">{{ $club->clubdesc }}</p>

                <div class="mt-4">
                    @auth
                        @php
                            $isHighCommittee = $club->members->contains(function ($member) {
                                return $member->id === Auth::id() && $member->pivot->position === 'high_committee';
                            });
                        @endphp

                        @if (
                            (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) ||
                                $isHighCommittee ||
                                Auth::user()->userRole === 'admin')
                            <a href="{{ route('club.edit', $club->id) }}"
                                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                Edit Club
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="mt-4">
                    @auth
                        @if (Auth::user()->userRole === 'student')
                            @php
                                // Check if user is already a member
                                $isMember = $club->members->contains(Auth::id());
                                // Check if user has a pending join request
                                $pendingRequest = $club->joinRequests
                                    ->where('user_id', Auth::id())
                                    ->where('status', 'pending')
                                    ->first();
                            @endphp

                            @if (!$isMember && $pendingRequest)
                                <button type="button"
                                    class="inline-block px-5 py-2 bg-yellow-400 text-white rounded-lg cursor-not-allowed">
                                    Waiting for Approval
                                </button>
                            @elseif (!$isMember)
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
    </div>
    {{-- ---------------------------------- Two Column Section ---------------------------------- --}}
    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Social Media + Contacts --}}
        <div class="space-y-6 lg:col-span-1">
            {{-- ---------------------------------- Social Media ---------------------------------- --}}
            <div class="bg-white rounded-lg shadow-lg p-6 ">
                <div class="flex items-center space-x-2 mb-4">
                    <h2 class="text-xl font-semibold">Club Social Media</h2>
                    <div class="relative group flex items-center">
                        <span
                            class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                            title="Information">?</span>

                        <div
                            class="absolute left-7 top-1/2 -translate-y-1/2 w-72 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                            Click a platform name to view or copy the social media link.
                        </div>
                    </div>
                </div>

                @if ($club->socials->count() > 0)
                    <div class="mt-4 border-t border-gray-200 pt-3 space-y-2" x-data="{ openId: null }">

                        @foreach ($club->socials as $social)
                            <div class="border border-gray-200 rounded-lg p-3 transition hover:bg-gray-50 hover:shadow-sm">
                                <button
                                    @click="openId === {{ $social->id }} ? openId = null : openId = {{ $social->id }}"
                                    class="w-full text-left text-gray-800 font-medium focus:outline-none">
                                    <span class="hover:text-blue-600 hover:underline transition duration-150">
                                        {{ $social->name }}
                                    </span>
                                </button>

                                <div x-show="openId === {{ $social->id }}" x-transition
                                    class="mt-2 text-sm text-gray-600 pl-1">
                                    <div class="flex items-start gap-3">
                                        <a href="{{ $social->link }}" target="_blank"
                                            class="text-blue-600 hover:underline break-all">
                                            {{ $social->link }}
                                        </a>

                                        {{-- Copy button --}}
                                        <button type="button"
                                            class="ml-auto text-sm px-2 py-1 border rounded text-gray-700 hover:bg-gray-100"
                                            @click="navigator.clipboard.writeText('{{ $social->link }}')
                                    .then(() => { $el.innerText='Copied'; setTimeout(() => $el.innerText='Copy', 1200) })
                                    .catch(() => alert('Copy failed'))">
                                            Copy
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic mt-4">No social media links published yet.</p>
                @endif

                {{-- Manage button for authorized users --}}
                @auth
                    @php
                        $isHighCommittee = Auth::user()
                            ->clubMemberships()
                            ->where('club_id', $club->id)
                            ->wherePivot('position', 'high_committee')
                            ->exists();
                    @endphp

                    @if (Auth::user()->userRole === 'admin' || $club->advisor_id === Auth::id() || $isHighCommittee)
                        <div class="mt-6 text-center">
                            <a href="{{ route('club.socials', ['clubId' => $club->id]) }}"
                                class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition">
                                Manage Social Media
                            </a>
                        </div>
                    @endif
                @endauth
            </div>

            {{-- ---------------------------------- Club Contacts ---------------------------------- --}}
            <div class="bg-white rounded-lg shadow-lg p-6">
                <span>
                    <div class="flex items-center space-x-2 mb-4">
                        <h2 class="text-xl font-semibold">Club Contacts</h2>
                        {{-- Tooltip --}}
                        <div class="relative group flex items-center">
                            <span
                                class="text-white bg-gray-400 rounded-full w-5 h-5 flex items-center justify-center text-sm font-bold cursor-pointer"
                                title="Information">?</span>

                            <div
                                class="absolute left-7 top-1/2 -translate-y-1/2 w-72 bg-gray-800 text-white text-sm rounded-md px-3 py-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-lg z-10">
                                Click on the name to view contact details of the individuals for this club.
                            </div>
                        </div>
                    </div>

                    @php
                        // Check advisor
                        $advisor = $club->advisor;
                        // Check High com
                        $highCommittee = $club->members->filter(function ($member) {
                            return $member->pivot->position === 'high_committee';
                        });
                    @endphp

                    <div class="space-y-4">
                        @if ($advisor)
                            <h3 class="mt-4 border-t border-gray-200 text-lg font-semibold text-gray-700">Club Advisor</h3>
                            <div x-data="{ open: false }" class="border rounded-lg p-3 hover:bg-gray-50 transition">
                                <button @click="open = !open"
                                    class="hover:text-blue-600 hover:underline transition duration-150 w-full text-left text-black-600 font-medium">
                                    {{ $advisor->name }} <span class="text-gray-500"> (Club Advisor)</span>
                                </button>
                                <div x-show="open" class="mt-2 pl-2 text-gray-700 text-sm " x-transition>
                                    <p><strong>Email:</strong> {{ $advisor->email }}</p>
                                    <p><strong>Phone:</strong> {{ $advisor->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($highCommittee->isNotEmpty())
                            <h3 class="text-lg font-semibold text-gray-700 mt-4">High Committee</h3>
                            @foreach ($highCommittee as $member)
                                <div x-data="{ open: false }" class="border rounded-lg p-3 hover:bg-gray-50 transition">
                                    <button @click="open = !open"
                                        class="hover:text-blue-600 hover:underline transition duration-150 w-full text-left text-black-600 font-medium">
                                        {{ $member->name }}
                                        <span class="text-gray-500">
                                            ({{ ucfirst($member->pivot->role ?? 'Member') }})
                                        </span>
                                    </button>
                                    <div x-show="open" class="mt-2 pl-2 text-gray-700 text-sm" x-transition>
                                        <p><strong>Email:</strong> {{ $member->email }}</p>
                                        <p><strong>Phone:</strong> {{ $member->phone_number ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="text-gray-500">No high committee members assigned yet.</p>
                        @endif
                    </div>

                    @auth
                        @php
                            $isHighCommittee = Auth::user()
                                ->clubMemberships()
                                ->where('club_id', $club->id)
                                ->wherePivot('position', 'high_committee')
                                ->exists();
                        @endphp
                    @else
                        @php
                            $isHighCommittee = false;
                        @endphp
                    @endauth

                    @auth
                        @if (Auth::user()->userRole === 'admin' || $club->advisor_id === Auth::id() || $isHighCommittee)
                            <div class="mt-6 text-center">
                                <a href="{{ route('club.showmember', $club->id) }}"
                                    class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                    Manage Club Members
                                </a>
                            </div>
                        @endif
                    @endauth
            </div>
            {{-- Dropdown script --}}
            <script src="//unpkg.com/alpinejs" defer></script>
            {{-- Buttons (no visible container) --}}
            <div class="flex justify-start gap-3 mt-2">
                <a href="{{ route('club.index', $club->id) }}"
                    class="px-4 py-2 mb-4 bg-orange-400 text-white rounded-lg hover:bg-orange-500 transition">
                    Back to Club Main Page
                </a>
            </div>
        </div>
        {{-- ---------------------------------- Right Column: Announcements ---------------------------------- --}}
        <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6 mb-10">

            @auth
                @php
                    $isHighCommittee = $club->members->contains(function ($member) {
                        return $member->id === Auth::id() && $member->pivot->position === 'high_committee';
                    });
                @endphp

                @if ((Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) || $isHighCommittee)
                    <div class="bg-gray-50 border border-gray-300 rounded-lg p-5 mb-5 shadow-sm">
                        <div class="space-y-3 text-gray-800 text-center">
                            <h4 class="text-lg font-semibold flex justify-center items-center gap-2 text-gray-700">
                                <span>Manage Activity</span>
                            </h4>

                            @if (Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id())
                                {{-- Advisor Controls --}}
                                <div class="flex flex-wrap justify-center gap-3">
                                    <a href="{{ route('announcements.create', $club->id) }}"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                        Manage Club Announcement
                                    </a>

                                    <button type="button"
                                        onclick="window.location='{{ route('manageactivity.show', $club->id) }}'"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                        Manage Club Activity Proposal
                                    </button>

                                    <button type="button"
                                        onclick="window.location='{{ route('viewreport.show', $club->id) }}'"
                                        class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                                        Manage Club Activity Report
                                    </button>
                                </div>
                            @elseif($isHighCommittee)
                                {{-- High Committee Controls --}}
                                <div class="flex flex-wrap justify-center gap-3">
                                    <a href="{{ route('announcements.create', $club->id) }}"
                                        class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                                        Manage Club Announcement
                                    </a>

                                    <button type="button"
                                        onclick="window.location='{{ route('proposeactivity.show', $club->id) }}'"
                                        class="px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition">
                                        Manage Club Activity
                                    </button>

                                    <button type="button"
                                        onclick="window.location='{{ route('submitreport.show', $club->id) }}'"
                                        class="px-4 py-2 bg-orange-600 text-white font-semibold rounded-lg shadow hover:bg-orange-700 hover:shadow-md transition">
                                        Submit Club Activity Report
                                    </button>

                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            @endauth
            {{-- ---------------------------------- Posted Activities Section ---------------------------------- --}}
            <div x-data="{ activeTab: 'announcements' }" class="w-full">
                <!-- Tabs -->
                <div class="flex justify-center border-b border-gray-300 mb-6">

                    <!-- Announcement Buttons -->
                    <button @click="activeTab = 'announcements'"
                        :class="activeTab === 'announcements' ? 'bg-orange-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-orange-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                        Club Announcements
                    </button>

                    <!-- Activity Buttons -->
                    <button @click="activeTab = 'activities'"
                        :class="activeTab === 'activities' ? 'bg-orange-600 text-white shadow-md' :
                            'text-gray-600 hover:bg-orange-100'"
                        class="px-5 py-2 rounded-t-lg border-b-2 border-transparent font-semibold transition duration-200">
                        Club Activities
                    </button>
                </div>

                <!-- TAB Club Activities -->
                <div x-show="activeTab === 'activities'" x-transition>
                    <h2
                        class="text-2xl font-semibold mb-6 text-gray-800 text-center border-b-4 border-orange-500 pb-2 rounded">
                        CLUB ACTIVITY
                    </h2>

                    @if ($postedActivities->count() > 0)
                        <div class="space-y-8">
                            @foreach ($postedActivities as $activity)
                                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                                    {{-- Header: Title and Posted Date --}}
                                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $activity->activity_title }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $activity->posted_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>

                                    @auth
                                        @php
                                            $isHighCommittee = $club->members->contains(function ($member) {
                                                return $member->id === Auth::id() &&
                                                    $member->pivot->position === 'high_committee';
                                            });
                                        @endphp

                                        @if ((Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) || $isHighCommittee)
                                            <div class="flex items-center justify-end p-4 border-b border-gray-100">
                                                <form
                                                    action="{{ route('postedactivity.destroy', [$club->id, $activity->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this posted activity?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                                        Delete Activity
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth

                                    {{-- Poster Image --}}
                                    @if ($activity->poster_image)
                                        <div class="p-4 flex justify-center">
                                            <img src="{{ asset('storage/' . $activity->poster_image) }}"
                                                alt="Activity Poster"
                                                class="w-full max-w-3xl h-auto object-cover rounded-lg border mb-4">
                                        </div>
                                    @endif

                                    {{-- Images --}}
                                    <div class="p-4">
                                        @if (!empty($activity->images))
                                            @php
                                                $images = is_array($activity->images)
                                                    ? $activity->images
                                                    : json_decode($activity->images, true);
                                            @endphp

                                            @if (is_array($images))
                                                <div
                                                    class="@if (count($images) === 1) flex justify-center
                                        @else grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 justify-items-center @endif
                                        mx-auto max-w-6xl w-full">
                                                    @foreach ($images as $img)
                                                        <div class="flex justify-center w-full">
                                                            <img src="{{ asset('storage/' . $img) }}"
                                                                class="w-full max-w-3xl h-auto object-cover rounded-lg"
                                                                alt="Activity Image">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-gray-500 text-sm mt-2 text-center">Image data invalid</p>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Badges: Level, DNA Category, GHOCS --}}
                                    <div class="flex items-center space-x-2 p-4 border-b border-gray-100">

                                        {{-- Level Badge --}}
                                        <div class="relative group">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold text-white rounded-full
            @if ($activity->level === 'Campus Level') bg-red-500
            @elseif($activity->level === 'University Level') bg-red-500
            @elseif($activity->level === 'National Level') bg-red-500
            @elseif($activity->level === 'International Level') bg-red-500
            @else bg-gray-500 @endif">
                                                {{ $activity->level }}
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
            @if ($activity->dna_category === 'Active Programme') bg-orange-500
            @elseif($activity->dna_category === 'Sports & Recreation') bg-orange-500
            @elseif($activity->dna_category === 'Entrepreneur') bg-orange-500
            @elseif($activity->dna_category === 'Global') bg-orange-500
            @elseif($activity->dna_category === 'Graduate') bg-orange-500
            @elseif($activity->dna_category === 'Leadership') bg-orange-500
            @else bg-gray-500 @endif">
                                                {{ $activity->dna_category }}
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
                                                {{ $activity->ghocs_element }}
                                            </span>
                                            <div
                                                class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 w-max bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                GHOCS Domain
                                            </div>
                                        </div>

                                    </div>



                                    {{-- Description --}}
                                    <div class="p-4 text-gray-700 leading-relaxed">
                                        {{ $activity->activity_description }}
                                    </div>

                                    {{-- Discussion / Footer --}}
                                    <div
                                        class="px-4 py-3 bg-gray-100 text-sm text-gray-600 border-t border-gray-200 flex items-center">
                                        <div class="flex-1"></div>
                                        @php
                                            // Check if user is already a member
                                            $isMember = $club->members->contains(Auth::id());
                                            // Check if user has a pending join request
                                            $pendingRequest = $club->joinRequests
                                                ->where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->first();
                                        @endphp
                                        @if (
                                            (Auth::check() && Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) ||
                                                $isHighCommittee ||
                                                $isMember ||
                                                'admin')
                                            <div class="flex-1 flex justify-center items-center text-center">
                                                <a href="{{ route('activity.show', $activity->id) }}"
                                                    class="inline-block bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg shadow hover:bg-orange-600 hover:shadow-md transition">
                                                    View Activity Discussion
                                                </a>
                                            </div>

                                            <div class="flex-1 flex justify-end">
                                                <p class="text-sm text-gray-600 flex items-center space-x-1">
                                                    <span><b>{{ $activity->comments->count() }}</b>
                                                        Total
                                                        Discussion{{ $activity->comments->count() !== 1 ? 's' : '' }}</span>
                                                </p>
                                            </div>
                                        @else
                                            <div class="flex justify-center w-full">
                                                <p class="text-gray-400 italic">Join this club to view discussions</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $postedActivities->links() }}
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-8">
                            <p>No club activities yet. Stay tuned!</p>
                        </div>
                    @endif
                </div>

                <!-- TAB Club Announcements -->
                <div x-show="activeTab === 'announcements'" x-transition>
                    <h2
                        class="text-2xl font-semibold mb-6 text-gray-800 text-center border-b-4 border-orange-500 pb-2 rounded">
                        CLUB ANNOUNCEMENT </h2>

                    @if ($announcements->count() > 0)
                        <div class="space-y-8">
                            @foreach ($announcements as $announcement)
                                <div class="bg-white border border-gray-200 rounded-xl shadow-md overflow-hidden">
                                    {{-- Header Line --}}
                                    <div class="flex items-center justify-between p-4 border-b border-gray-100">
                                        <h3 class="text-lg font-bold text-gray-800">{{ $announcement->title }}</h3>
                                        <p class="text-sm text-gray-500">
                                            {{ $announcement->created_at->format('d M Y, h:i A') }}
                                        </p>
                                    </div>
                                    @auth
                                        @php
                                            $isHighCommittee = $club->members->contains(function ($member) {
                                                return $member->id === Auth::id() &&
                                                    $member->pivot->position === 'high_committee';
                                            });
                                        @endphp

                                        @if ((Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) || $isHighCommittee)
                                            <div class="flex items-center justify-end p-4 border-b border-gray-100">

                                                <form
                                                    action="{{ route('announcements.destroy', [$club->id, $announcement->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this announcement?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                                                        Delete Announcement
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth

                                    {{-- Image --}}
                                    @if ($announcement->attachment)
                                        <div class="p-4 w-full bg-gray-50 flex justify-center">
                                            <img src="{{ asset('storage/' . $announcement->attachment) }}"
                                                alt="Announcement Image"
                                                class="w-full max-w-full rounded-lg object-contain">
                                        </div>
                                    @endif



                                    {{-- Content --}}
                                    <div class="p-4 text-gray-700 leading-relaxed">
                                        {{ $announcement->content }}
                                    </div>

                                    {{-- Footer Line --}}
                                    <div
                                        class="px-4 py-3 bg-gray-100 text-sm text-gray-600 border-t border-gray-200 flex items-center">
                                        @php
                                            // Check if user is already a member
                                            $isMember = $club->members->contains(Auth::id());
                                            // Check if user has a pending join request
                                            $pendingRequest = $club->joinRequests
                                                ->where('user_id', Auth::id())
                                                ->where('status', 'pending')
                                                ->first();
                                        @endphp
                                        @if (
                                            (Auth::check() && Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) ||
                                                $isHighCommittee ||
                                                $isMember ||
                                                'admin')
                                            {{-- @if ((Auth::user()->userRole === 'advisor' && $club->advisor_id === Auth::id()) || $isHighCommittee) (Guest tkleh view club) --}}
                                            <div class="flex-1"></div>

                                            <div class="flex-1 flex justify-center">
                                                <a href="{{ route('announcement.show', $announcement->id) }}"
                                                    class="inline-block bg-orange-500 text-white font-semibold px-5 py-2 rounded-lg shadow hover:bg-orange-600 hover:shadow-md transition">
                                                    View Announcement Discussion
                                                </a>
                                            </div>

                                            <div class="flex-1 flex justify-end">
                                                <p class="text-sm text-gray-600 flex items-center space-x-1">
                                                    <span><b>{{ $announcement->comments->count() }}</b>
                                                        Total
                                                        Discussion{{ $announcement->comments->count() !== 1 ? 's' : '' }}</span>
                                                </p>
                                            </div>
                                        @else
                                            <div class="flex justify-center w-full">
                                                <p class="text-gray-400 italic">Join this club to view discussions</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            @endforeach

                            <div class="mt-8">
                                {{ $announcements->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center text-gray-500 py-10">
                            <p>No club announcements yet. Stay tuned!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="//unpkg.com/alpinejs" defer></script>

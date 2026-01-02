@extends('layoutStyle.styling')
{{-- student and secretary access to GHOC page. Student can see their points and submit my excellence proposal. Secretary can manage --}}
@section('content')
    <div class="min-h-screen py-10 px-0">

        {{-- MAIN GRID TOP SECTION --}}
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">

            {{-- LEFT PANEL --}}
            @auth
                @if (Auth::user()->userRole === 'student' || Auth::user()->userRole === 'secretary')
                    <div class="bg-white rounded-xl shadow overflow-hidden lg:col-span-1 h-100">

                        <div class="bg-blue-800 text-white px-6 py-4">
                            <h2 class="text-3xl font-bold text-center">My Excellence</h2>
                        </div>

                        <div class="p-4">

                            <div class="space-y-3 mb-6 pt-4">

                                @if (Auth::user()->userRole === 'student')
                                    <a href="{{ route('merit.create') }}"
                                        class="block text-center bg-orange-400 text-white px-4 py-2 rounded-lg hover:bg-orange-500">
                                        Submit My Excellence Request
                                    </a>

                                    <a href="{{ route('skill_proposals.create') }}"
                                        class="block text-center bg-yellow-400 text-white px-4 py-2 rounded-lg hover:bg-yellow-500">
                                        Submit Skill Development Proposal
                                    </a>

                                    <a href="{{ route('transcript.show', Auth::id()) }}"
                                        class="block text-center bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                        Print Transcript
                                    </a>
                                @elseif (Auth::user()->userRole === 'secretary')
                                    <a href="{{ route('merit.manage') }}"
                                        class="block text-center bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800">
                                        Manage My Excellence Requests
                                    </a>

                                    <a href="{{ route('secretary.skill_proposals') }}"
                                        class="block text-center bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-800">
                                        Manage Skill Development Proposals
                                    </a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endif
            @endauth

            {{-- RIGHT PANEL --}}
            @if ((Auth::check() && Auth::user()->userRole === 'student') || 'secretary')
                <div class="bg-white rounded-xl overflow-hidden  lg:col-span-2">

                    <div class="bg-blue-800 text-white px-6 py-4">
                        <h3 class="text-2xl font-bold text-center">GHOCS and Activity Involvement</h3>
                    </div>

                    <div class="p-4">
                        @if ($studentPoints)
                            {{-- Alpine.js Tabs --}}
                            <div x-data="{ openTab: 1 }">
                                {{-- TAB BUTTONS --}}
                                <div class="flex border-b border-gray-300 mb-6 space-x-2">
                                    <button @click="openTab = 1"
                                        :class="openTab === 1 ?
                                            'bg-blue-600 text-white shadow-md' :
                                            'text-gray-600 hover:bg-blue-100'"
                                        class="px-5 py-2 rounded-t-lg transition duration-200">
                                        Overview
                                    </button>

                                    <button @click="openTab = 2"
                                        :class="openTab === 2 ?
                                            'bg-green-600 text-white shadow-md' :
                                            'text-gray-600 hover:bg-green-100'"
                                        class="px-5 py-2 rounded-t-lg transition duration-200">
                                        UniKL DNA
                                    </button>

                                    <button @click="openTab = 3"
                                        :class="openTab === 3 ?
                                            'bg-purple-600 text-white shadow-md' :
                                            'text-gray-600 hover:bg-purple-100'"
                                        class="px-5 py-2 rounded-t-lg transition duration-200">
                                        SPICES Domain
                                    </button>

                                    <button @click="openTab = 4"
                                        :class="openTab === 4 ?
                                            'bg-orange-400 text-white shadow-md' :
                                            'text-gray-600 hover:bg-orange-100'"
                                        class="px-5 py-2 rounded-t-lg transition duration-200">
                                        GHOCS Guide
                                    </button>
                                </div>


                                {{-- TAB CONTENT --}}
                                <div>
                                    {{-- SUMMARY TAB --}}
                                    <div x-show="openTab === 1" x-transition class="space-y-6">
                                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">GHOCS Points
                                            Overview
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                                            <div class="p-5 bg-red-50 border-l-4 border-red-600 rounded-lg -sm relative">
                                                <h4 class="text-red-900 font-bold flex items-center gap-2">
                                                    Skill Development Points

                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-red-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Points awarded from subjects listed under student development
                                                            section such as Languages and common General Subjects.
                                                        </span>
                                                    </span>
                                                </h4>

                                                <p class="text-3xl font-bold text-red-700">
                                                    {{ $studentPoints->skill_development }}
                                                </p>
                                            </div>

                                            <div class="p-5 bg-green-50 border-l-4 border-green-600 rounded-lg -sm">
                                                <h4 class="text-green-900 font-bold">UniKL DNA Points
                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-green-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Points awarded from UniKL DNA categories.
                                                        </span>
                                                    </span>
                                                </h4>
                                                <p class="text-3xl font-bold text-green-700">
                                                    {{ $studentPoints->dna_points }}
                                                </p>
                                            </div>
                                            <div class="p-5 bg-purple-50 border-l-4 border-purple-600 rounded-lg -sm">
                                                <h4 class="text-purple-900 font-bold">S.P.I.C.E Points
                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-purple-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute right-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Points awarded from UniKL S.P.I.C.E.S domain.
                                                        </span>
                                                    </span>
                                                </h4>
                                                <p class="text-3xl font-bold text-purple-700">
                                                    {{ $studentPoints->ghocs_spiritual + $studentPoints->ghocs_physical + $studentPoints->ghocs_intellectual + $studentPoints->ghocs_career + $studentPoints->ghocs_emotional + $studentPoints->ghocs_social }}
                                                </p>
                                            </div>
                                            <div class="p-5 bg-orange-50 border-l-4 border-orange-600 rounded-lg -sm">
                                                <h4 class="text-orange-900 font-bold">My Excellence Points
                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-orange-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Points awarded from My Excellence according to achievement
                                                            level.
                                                        </span>
                                                    </span>
                                                </h4>
                                                <p class="text-3xl font-bold text-orange-700">
                                                    {{ $studentPoints->excellence_points }}</p>
                                            </div>
                                            <div class="p-5 bg-yellow-50 border-l-4 border-yellow-600 rounded-lg -sm">
                                                <h4 class="text-yellow-900 font-bold">Management Skills Points
                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-yellow-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Points awarded for each club join and position held (High
                                                            Committee).
                                                        </span>
                                                    </span>
                                                </h4>
                                                <p class="text-3xl font-bold text-yellow-700">
                                                    {{ $studentPoints->management_skills }}</p>
                                            </div>
                                            <div class="p-5 bg-blue-50 border-l-4 border-blue-600 rounded-lg -sm">
                                                <h4 class="text-blue-900 font-bold">Cumulative GHOCS
                                                    <!-- Tooltip Trigger -->
                                                    <span class="relative group">
                                                        <span class="text-blue-700 font-bold cursor-pointer">?</span>

                                                        <!-- Tooltip Box -->
                                                        <span
                                                            class="z-50 absolute right-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                            Total points accumulated from all categories.
                                                        </span>
                                                    </span>
                                                </h4>
                                                <p class="text-3xl font-bold text-blue-700">
                                                    {{ $studentPoints->total_points }}
                                                </p>
                                            </div>
                                        </div>

                                        {{-- SC TAB --}}
                                        <div class="mt-8">
                                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">UNIKL DNA
                                                Transferable
                                                Skills <!-- Tooltip Trigger -->
                                                <span class="relative group">
                                                    <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                                    <!-- Tooltip Box -->
                                                    <span
                                                        class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                        DNA Transferable Skills points is gained from multiple UniKL DNA
                                                        categories.
                                                    </span>
                                                </span>
                                            </h3>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-5">
                                                @php
                                                    $scList = [
                                                        'SC1' => 'Self Awareness & Integrity',
                                                        'SC2' => 'Communication Skills & Professional  Sociability',
                                                        'SC3' => 'Open Mindedness & Lifelong Learning',
                                                        'SC4' => 'Practical, Scientific & Problem Solving Skills',
                                                        'SC5' => 'Entrepreneurial Ability',
                                                    ];
                                                @endphp

                                                @foreach ($scList as $scCode => $scName)
                                                    <div
                                                        class="p-4 bg-orange-50 rounded-lg  text-center h-40 flex flex-col justify-center ">
                                                        <h5 class="font-bold text-orange-900 text-sm"
                                                            title="{{ $scName }} ({{ $scCode }})">
                                                            {{ $scName }} ({{ $scCode }})
                                                        </h5>
                                                        <p class="text-2xl font-extrabold text-orange-800">
                                                            {{ $studentPoints->$scCode }}</p>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    {{-- DNA TAB --}}
                                    <div x-show="openTab === 2" x-transition class="space-y-6">
                                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">UniKL DNA<span
                                                class="relative group">
                                                <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                                <!-- Tooltip Box -->
                                                <span
                                                    class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                    UniKL DNA mainly contributes into the calculation of transferable
                                                    skills.
                                                </span>
                                            </span>
                                        </h3>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-5 mt-6">
                                            @foreach ([
            'Active Programme' => $studentPoints->dna_active_programme,
            'Sports & Recreation' => $studentPoints->dna_sports_recreation,
            'Entrepreneur' => $studentPoints->dna_entrepreneur,
            'Global' => $studentPoints->dna_global,
            'Graduate' => $studentPoints->dna_graduate,
            'Leadership' => $studentPoints->dna_leadership,
        ] as $key => $value)
                                                <div class="p-4 bg-green-50 rounded-lg  text-center">
                                                    <h5 class="font-semibold text-green-800">{{ $key }}</h5>
                                                    <p class="text-xl font-extrabold text-green-700">{{ $value }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- GHOCS TAB --}}
                                    <div x-show="openTab === 3" x-transition class="space-y-6">
                                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">UniKL activities
                                            domain
                                            (S.P.I.C.E.S)
                                            <span class="relative group">
                                                <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                                <!-- Tooltip Box -->
                                                <span
                                                    class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                    S.P.I.C.E.S is the heart in developing “holistic graduate” leading to
                                                    student co-ccurricular involvement in various activities.
                                                </span>
                                            </span>
                                        </h3>
                                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-3 gap-5 mt-6">
                                            @foreach ([
            'Spiritual' => $studentPoints->ghocs_spiritual,
            'Physical' => $studentPoints->ghocs_physical,
            'Intellectual' => $studentPoints->ghocs_intellectual,
            'Career' => $studentPoints->ghocs_career,
            'Emotional' => $studentPoints->ghocs_emotional,
            'Social' => $studentPoints->ghocs_social,
        ] as $key => $value)
                                                <div class="p-4 bg-purple-50 rounded-lg  text-center">
                                                    <h5 class="font-bold text-purple-900">{{ $key }}</h5>
                                                    <p class="text-xl font-extrabold text-purple-800">{{ $value }}
                                                    </p>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                    {{-- tab 4 --}}
                                    <div x-show="openTab === 4" x-transition class="space-y-6">
                                        <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">GHOCS Guide
                                            <span class="relative group">
                                                <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                                <!-- Tooltip Box -->
                                                <span
                                                    class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                                    Guide to fill your My Excellence Request to get the points you want for
                                                    specific
                                                    UniKL DNA Transferable Skill's radar chart.
                                                </span>
                                            </span>
                                        </h3>
                                        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-5 mt-6 px-8 ">

                                            <!-- HEADER 1 -->
                                            <div x-data="{ open: false }"
                                                class="bg-red-50 rounded-lg shadow p-4 cursor-pointer text-red-900 hover:bg-red-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    Skill Development
                                                </h3>
                                                <div x-show="open" x-transition
                                                    class="mt-2 text-gray-900 text-justify px-8">
                                                    Skill Development is a module that focus on continued learning even
                                                    outside classrooms.
                                                    Students can obtain Skill Development points via subjects listed under
                                                    student development
                                                    sections such as Languages and common General Subjects.
                                                </div>
                                            </div>

                                            <!-- HEADER 2 -->
                                            <div x-data="{ open: false }"
                                                class="bg-green-50 rounded-lg shadow p-4 cursor-pointer text-green-900 hover:bg-green-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    UniKL DNA Program Component
                                                </h3>
                                                <div x-show="open" x-transition
                                                    class="mt-2 text-gray-900 text-justify px-8">
                                                    Each GHOCS claimable activity from clubs or news posted on UniKLSKILL
                                                    each have a badge for Activity Level category, DNA program category and
                                                    SPICES Domain
                                                    category.
                                                    Each category of DNA Program Component contributes to building DNA
                                                    Transferable
                                                    Skills on your radar chart transcript later on. You can refer to the
                                                    table below
                                                    for description of each Program to better learn how to manually assign
                                                    it when you want
                                                    to claim.

                                                    <!-- table -->
                                                    <div class="overflow-x-auto mt-6 px-4">
                                                        <table class="min-w-full bg-white border border-gray-300 shadow">

                                                            <thead class="bg-green-800 text-white">
                                                                <tr>
                                                                    <th class="py-3 px-4 text-center font-extrabold">UniKL
                                                                        DNA Program</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Description of Activity</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="text-gray-800">
                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Active</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focuses on community involvement & noble
                                                                                citizenship (Community Service subject).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Sports & Recreation
                                                                    </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focuses on sports and recreation activities.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Entrepreneur </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focuses on business, social enterprise and
                                                                                innovation.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Global</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focuses on international/ cultural
                                                                                awareness.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Graduate</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focusing for skills needed while they in
                                                                                university, including study skill, career
                                                                                development workshop, corporate visit,
                                                                                University Industrialmanship.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Leadership</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Focusing on USRC/ SRC, and any related
                                                                                leadership program.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- HEADER 3 -->
                                            <div x-data="{ open: false }"
                                                class="bg-purple-50 rounded-lg shadow p-4 cursor-pointer text-purple-900 hover:bg-purple-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    S.P.I.C.E.S Point
                                                </h3>
                                                <div x-show="open" x-transition
                                                    class="mt-2 text-gray-700 text-justify px-8">
                                                    Each activity conducted by students will fall under SIX domains
                                                    classified as Spiritual (S), Physical (P), Intellectual (I), Career (C),
                                                    Emotion (E) and Social (S). SPICES is the heart in developing “holistic
                                                    graduate” leading to student success, area of development which can be
                                                    refered as below :

                                                    <!-- table -->
                                                    <div class="overflow-x-auto mt-6 px-4">
                                                        <table class="min-w-full bg-white border border-gray-300 shadow">

                                                            <thead class="bg-purple-800 text-white">
                                                                <tr>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Achievement Level</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Description of Area Development</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="text-gray-800">
                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold"> (S) Social </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Having the ability to form relationship,
                                                                                engage with others > explore the potential >
                                                                                share the experience.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold"> (P) Physical </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Having and applying knowledge about physical
                                                                                strength (body) to keep fit and energize.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">(I) Intellectual </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Academic Excellent by exposing the ability
                                                                                to learn, gain skills, and reflect the
                                                                                knowledge (learn, > un-learn, >
                                                                                re-learn).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">(C) Career </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Ability to map again the goal and needs to
                                                                                success.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold"> (E) Emotional </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Ability to understand & match with situation
                                                                                to react upon.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">(S) Spiritual </td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Understanding and having ability to be aware
                                                                                of own culture & respect others.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- HEADER 4 -->
                                            <div x-data="{ open: false }"
                                                class="bg-orange-50 rounded-lg shadow p-4 cursor-pointer text-orange-900 hover:bg-orange-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    My Excellence Point
                                                </h3>
                                                <div x-show="open" x-transition
                                                    class="mt-2 text-gray-700 text-justify px-8">
                                                    Excellence is a module to record student's achievement and convert it to
                                                    points that will
                                                    contribute to the total cummulative GHOCS points. Below is example and
                                                    the value per Achievement
                                                    Level when student want to submit a request.

                                                    <div class="overflow-x-auto mt-6 px-4">
                                                        <table class="min-w-full bg-white border border-gray-300 shadow">

                                                            <thead class="bg-orange-800 text-white">
                                                                <tr>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Achievement Level and Points</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Excellence Points Earned</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Example of Activity</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="text-gray-800">
                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Representative</td>
                                                                    <td class="py-3 px-4 font-bold"> (10 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Sport Competition (MASUM, KSSU).
                                                                            </li>
                                                                            <li>Final Year Project Competition.
                                                                            </li>
                                                                            <li>Project Exhibition.
                                                                            </li>
                                                                            <li>Programming Competition.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Special Award</td>
                                                                    <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Best Athlete.
                                                                            </li>
                                                                            <li>Young Officer (Leftenan Muda Pertahan Awam).
                                                                            </li>
                                                                            <li>Icon Awards.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Participate (Special
                                                                        Invitation)</td>
                                                                    <td class="py-3 px-4 font-bold"> (5 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Presenting at event or conference.
                                                                            </li>
                                                                            <li>Complete Module/Training.
                                                                            </li>
                                                                            <li>Global Excellence Leadership MARA (GEL
                                                                                MARA).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">International Buddy
                                                                        (Short Semester)</td>
                                                                    <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Buddy/ befriender to international/ exchange
                                                                                students for a short semester (less than 3
                                                                                Months).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">International Buddy
                                                                        (Full Semester) </td>
                                                                    <td class="py-3 px-4 font-bold"> (25 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>A student buddy for Exchange studnet for a
                                                                                full semester (More than 3 Months).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Exchange Students
                                                                        (Short Semester)</td>
                                                                    <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>ISEM/ Global Mobility activities (less than
                                                                                3 Months).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Exchange Students
                                                                        (Full Semester) </td>
                                                                    <td class="py-3 px-4 font-bold"> (25 Points)</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>ISEM/ Global Mobility activities (More than
                                                                                3 Months).
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- HEADER 5 -->
                                            <div x-data="{ open: false }"
                                                class="bg-yellow-50 text-yellow-800 rounded-lg shadow p-4 cursor-pointer hover:bg-yellow-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    Management Skills Point
                                                </h3>
                                                <div x-show="open" x-transition class="mt-2 text-gray-700 text-justify">
                                                    Management Skills come from the student's ability to manage either their
                                                    time as a club member
                                                    or their ability to give commitment on managing one or several clubs as
                                                    the club's High Committee Member.
                                                    Below are table of reference detailing some of the responsibility of
                                                    both Club Member and High Committee of the club.

                                                    <!-- table -->
                                                    <div class="overflow-x-auto mt-6 px-4">
                                                        <table class="min-w-full bg-white border border-gray-300 shadow">

                                                            <thead class="bg-yellow-800 text-white">
                                                                <tr>
                                                                    <th class="py-3 px-4 text-center font-extrabold">Role
                                                                    </th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Management Skills Point</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Description of Role</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="text-gray-800">
                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Club Member</td>
                                                                    <td class="py-3 px-4 font-bold">5 Points</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Able to discuss on each activity posted on
                                                                                posted club activites.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">High Committee Member
                                                                    </td>
                                                                    <td class="py-3 px-4 font-bold">15 Points</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Responsible in managing club members
                                                                                (Add,Remove,Promote and Demote).
                                                                            </li>
                                                                            <li>Responsible in keeping the club active
                                                                                (Submit
                                                                                club activity proposal to club advisor).
                                                                            </li>
                                                                            <li>Submit announcement to keep the club members
                                                                                update.
                                                                            </li>
                                                                            <li>Each High Committee will have respective
                                                                                position in clubs. If your new club proposal
                                                                                is
                                                                                approved, then you
                                                                                will be automatically assigned as the club's
                                                                                leader.
                                                                            </li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- HEADER 6 -->
                                            <div x-data="{ open: false }"
                                                class="bg-blue-50 rounded-lg shadow p-4 cursor-pointer text-blue-900 hover:bg-blue-100">
                                                <h3 @click="open = !open" class="font-bold text-center">
                                                    UniKL DNA Transferable Skills
                                                </h3>
                                                <div x-show="open" x-transition
                                                    class="mt-2 text-gray-900 text-justify px-8">
                                                    UniKL DNA Points will be converted into UniKL DNA Transferable Skills
                                                    for your radar chart on
                                                    your printable GHOCS transcript. You can refer to badges underneath
                                                    activities of clubs or news
                                                    that is GHOCS claimable. The details of each DNA and the points it
                                                    contribute to which radar chart
                                                    SC is as follows. You can refer to the table if you need help on how to
                                                    manually assign which domain
                                                    of DNA the activity you wish to claim.

                                                    <!-- table -->
                                                    <div class="overflow-x-auto mt-6 px-4">
                                                        <table class="min-w-full bg-white border border-gray-300 shadow">

                                                            <thead class="bg-blue-800 text-white">
                                                                <tr>
                                                                    <th class="py-3 px-4 text-center font-extrabold">UNIKL
                                                                        DNA
                                                                        Transferable Skills</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">
                                                                        Description</th>
                                                                    <th class="py-3 px-4 text-center font-extrabold">UniKL
                                                                        DNA
                                                                        Category Distribution</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody class="text-gray-800">
                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Self Awareness &
                                                                        Integrity (SC 1)</td>
                                                                    <td class="py-3 px-4 font-bold">Having good values that
                                                                        are honest, courageous, confident yet humble, high
                                                                        integrity and responsibility.</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Active Programme</li>
                                                                            <li>Sports & Recreation</li>
                                                                            <li>Leadership</li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Communication
                                                                        Skills & Professional Sociability (SC 2)</td>
                                                                    <td class="py-3 px-4 font-bold">Able to express their
                                                                        though clearly, confidently and effectively in
                                                                        appropriate ways by listening and interact
                                                                        respectfully with others.</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Active Programme</li>
                                                                            <li>Sports & Recreation</li>
                                                                            <li>Global</li>
                                                                            <li>Graduate</li>
                                                                            <li>Leadership</li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Open Mindedness &
                                                                        Lifelong Learning (SC 3)</td>

                                                                    <td class="py-3 px-4 font-bold">Receptive to new and
                                                                        different ideas or the opinion of others and don't
                                                                        impose their belief on others by accepting all of
                                                                        life's perceptive and realities.</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Active Programme</li>
                                                                            <li>Sports & Recreation</li>
                                                                            <li>Global</li>
                                                                            <li>Graduate</li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Practical,
                                                                        Scientific & Problem Solving Skills (SC 4)</td>
                                                                    <td class="py-3 px-4 font-bold">Always looking foward
                                                                        to strive for excellent in working environment and
                                                                        also their life and community.</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Entrepreneur</li>
                                                                            <li>Graduate</li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                                <tr class="border-t">
                                                                    <td class="py-3 px-4 font-bold">Entrepreneurial
                                                                        Ability (SC 5)</td>
                                                                    <td class="py-3 px-4 font-bold">Always creative and
                                                                        optimistic with entrepreneurial mind set.</td>
                                                                    <td class="py-3 px-4">
                                                                        <ul class="list-disc ml-5">
                                                                            <li>Entrepreneur</li>
                                                                            <li>Leadership</li>
                                                                        </ul>
                                                                    </td>
                                                                </tr>

                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        @elseif ('secretary')
                            {{-- secretary guide on manually assigning GHOCS points --}}
                            <div x-show="openTab === 4" x-transition class="space-y-6">
                                <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">GHOCS Reference
                                    <span class="relative group">
                                        <span class="text-grey-700 font-bold cursor-pointer">?</span>

                                        <!-- Tooltip Box -->
                                        <span
                                            class="absolute left-6 top-1/2 -translate-y-1/2 w-52 p-2 bg-gray-800 text-white text-sm rounded-lg opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                            Guide to fill My Excellence Request manually
                                        </span>
                                    </span>
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-5 mt-6 px-8 ">

                                    {{--
                                    <!-- HEADER 1 -->
                                    <div x-data="{ open: false }"
                                        class="bg-blue-500 rounded-lg shadow p-4 cursor-pointer text-white hover:bg-blue-700">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            GHOCS Manual
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-900 text-justify px-8">
                                            Download PDF
                                        </div>
                                    </div>
                                    --}}
                                    <!-- HEADER 1 -->
                                    <div x-data="{ open: false }"
                                        class="bg-red-50 rounded-lg shadow p-4 cursor-pointer text-red-900 hover:bg-red-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            Skill Development
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-900 text-justify px-8">
                                            Skill Development is a module that focus on continued learning even
                                            outside classrooms.
                                            Students can obtain Skill Development points via subjects listed
                                            under
                                            student development
                                            sections such as Languages and common General Subjects.
                                        </div>
                                    </div>

                                    <!-- HEADER 2 -->
                                    <div x-data="{ open: false }"
                                        class="bg-green-50 rounded-lg shadow p-4 cursor-pointer text-green-900 hover:bg-green-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            UniKL DNA Program Component
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-900 text-justify px-8">
                                            Each GHOCS claimable activity from clubs or news posted on
                                            UniKLSKILL
                                            each have a badge for Activity Level category, DNA program category
                                            and
                                            SPICES Domain
                                            category.
                                            Each category of DNA Program Component contributes to building DNA
                                            Transferable
                                            Skills on your radar chart transcript later on. You can refer to the
                                            table below
                                            for description of each Program to better learn how to manually
                                            assign
                                            it when you want
                                            to claim.

                                            <!-- table -->
                                            <div class="overflow-x-auto mt-6 px-4">
                                                <table class="min-w-full bg-white border border-gray-300 shadow">

                                                    <thead class="bg-green-800 text-white">
                                                        <tr>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                UniKL
                                                                DNA Program</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Description of Activity</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-gray-800">
                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Active</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focuses on community involvement & noble
                                                                        citizenship (Community Service subject).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Sports & Recreation
                                                            </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focuses on sports and recreation
                                                                        activities.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Entrepreneur </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focuses on business, social enterprise
                                                                        and
                                                                        innovation.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Global</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focuses on international/ cultural
                                                                        awareness.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Graduate</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focusing for skills needed while they in
                                                                        university, including study skill,
                                                                        career
                                                                        development workshop, corporate visit,
                                                                        University Industrialmanship.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Leadership</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Focusing on USRC/ SRC, and any related
                                                                        leadership program.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- HEADER 3 -->
                                    <div x-data="{ open: false }"
                                        class="bg-purple-50 rounded-lg shadow p-4 cursor-pointer text-purple-900 hover:bg-purple-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            S.P.I.C.E.S Point
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-700 text-justify px-8">
                                            Each activity conducted by students will fall under SIX domains
                                            classified as Spiritual (S), Physical (P), Intellectual (I), Career
                                            (C),
                                            Emotion (E) and Social (S). SPICES is the heart in developing
                                            “holistic
                                            graduate” leading to student success, area of development which can
                                            be
                                            refered as below :

                                            <!-- table -->
                                            <div class="overflow-x-auto mt-6 px-4">
                                                <table class="min-w-full bg-white border border-gray-300 shadow">

                                                    <thead class="bg-purple-800 text-white">
                                                        <tr>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Achievement Level</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Description of Area Development</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-gray-800">
                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold"> (S) Social </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Having the ability to form relationship,
                                                                        engage with others > explore the
                                                                        potential >
                                                                        share the experience.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold"> (P) Physical </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Having and applying knowledge about
                                                                        physical
                                                                        strength (body) to keep fit and
                                                                        energize.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">(I) Intellectual
                                                            </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Academic Excellent by exposing the
                                                                        ability
                                                                        to learn, gain skills, and reflect the
                                                                        knowledge (learn, > un-learn, >
                                                                        re-learn).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">(C) Career </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Ability to map again the goal and needs
                                                                        to
                                                                        success.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold"> (E) Emotional
                                                            </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Ability to understand & match with
                                                                        situation
                                                                        to react upon.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">(S) Spiritual </td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Understanding and having ability to be
                                                                        aware
                                                                        of own culture & respect others.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- HEADER 4 -->
                                    <div x-data="{ open: false }"
                                        class="bg-orange-50 rounded-lg shadow p-4 cursor-pointer text-orange-900 hover:bg-orange-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            My Excellence Point
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-700 text-justify px-8">
                                            Excellence is a module to record student's achievement and convert
                                            it to
                                            points that will
                                            contribute to the total cummulative GHOCS points. Below is example
                                            and
                                            the value per Achievement
                                            Level when student want to submit a request.

                                            <div class="overflow-x-auto mt-6 px-4">
                                                <table class="min-w-full bg-white border border-gray-300 shadow">

                                                    <thead class="bg-orange-800 text-white">
                                                        <tr>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Achievement Level and Points</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Excellence Points Earned</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Example of Activity</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-gray-800">
                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Representative</td>
                                                            <td class="py-3 px-4 font-bold"> (10 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Sport Competition (MASUM, KSSU).
                                                                    </li>
                                                                    <li>Final Year Project Competition.
                                                                    </li>
                                                                    <li>Project Exhibition.
                                                                    </li>
                                                                    <li>Programming Competition.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Special Award</td>
                                                            <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Best Athlete.
                                                                    </li>
                                                                    <li>Young Officer (Leftenan Muda Pertahan
                                                                        Awam).
                                                                    </li>
                                                                    <li>Icon Awards.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Participate
                                                                (Special
                                                                Invitation)</td>
                                                            <td class="py-3 px-4 font-bold"> (5 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Presenting at event or conference.
                                                                    </li>
                                                                    <li>Complete Module/Training.
                                                                    </li>
                                                                    <li>Global Excellence Leadership MARA (GEL
                                                                        MARA).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">International Buddy
                                                                (Short Semester)</td>
                                                            <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Buddy/ befriender to international/
                                                                        exchange
                                                                        students for a short semester (less than
                                                                        3
                                                                        Months).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">International Buddy
                                                                (Full Semester) </td>
                                                            <td class="py-3 px-4 font-bold"> (25 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>A student buddy for Exchange studnet for
                                                                        a
                                                                        full semester (More than 3 Months).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Exchange Students
                                                                (Short Semester)</td>
                                                            <td class="py-3 px-4 font-bold"> (20 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>ISEM/ Global Mobility activities (less
                                                                        than
                                                                        3 Months).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Exchange Students
                                                                (Full Semester) </td>
                                                            <td class="py-3 px-4 font-bold"> (25 Points)</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>ISEM/ Global Mobility activities (More
                                                                        than
                                                                        3 Months).
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- HEADER 5 -->
                                    <div x-data="{ open: false }"
                                        class="bg-yellow-50 text-yellow-800 rounded-lg shadow p-4 cursor-pointer hover:bg-yellow-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            Management Skills Point
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-700 text-justify">
                                            Management Skills come from the student's ability to manage either
                                            their
                                            time as a club member
                                            or their ability to give commitment on managing one or several clubs
                                            as
                                            the club's High Committee Member.
                                            Below are table of reference detailing some of the responsibility of
                                            both Club Member and High Committee of the club.

                                            <!-- table -->
                                            <div class="overflow-x-auto mt-6 px-4">
                                                <table class="min-w-full bg-white border border-gray-300 shadow">

                                                    <thead class="bg-yellow-800 text-white">
                                                        <tr>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Role
                                                            </th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Management Skills Point</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Description of Role</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-gray-800">
                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Club Member</td>
                                                            <td class="py-3 px-4 font-bold">5 Points</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Able to discuss on each activity posted
                                                                        on
                                                                        posted club activites.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">High Committee
                                                                Member
                                                            </td>
                                                            <td class="py-3 px-4 font-bold">15 Points</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Responsible in managing club members
                                                                        (Add,Remove,Promote and Demote).
                                                                    </li>
                                                                    <li>Responsible in keeping the club active
                                                                        (Submit
                                                                        club activity proposal to club advisor).
                                                                    </li>
                                                                    <li>Submit announcement to keep the club
                                                                        members
                                                                        update.
                                                                    </li>
                                                                    <li>Each High Committee will have respective
                                                                        position in clubs. If your new club
                                                                        proposal
                                                                        is
                                                                        approved, then you
                                                                        will be automatically assigned as the
                                                                        club's
                                                                        leader.
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <!-- HEADER 6 -->
                                    <div x-data="{ open: false }"
                                        class="bg-blue-50 rounded-lg shadow p-4 cursor-pointer text-blue-900 hover:bg-blue-100">
                                        <h3 @click="open = !open" class="font-bold text-center">
                                            UniKL DNA Transferable Skills
                                        </h3>
                                        <div x-show="open" x-transition class="mt-2 text-gray-900 text-justify px-8">
                                            UniKL DNA Points will be converted into UniKL DNA Transferable
                                            Skills
                                            for your radar chart on
                                            your printable GHOCS transcript. You can refer to badges underneath
                                            activities of clubs or news
                                            that is GHOCS claimable. The details of each DNA and the points it
                                            contribute to which radar chart
                                            SC is as follows. You can refer to the table if you need help on how
                                            to
                                            manually assign which domain
                                            of DNA the activity you wish to claim.

                                            <!-- table -->
                                            <div class="overflow-x-auto mt-6 px-4">
                                                <table class="min-w-full bg-white border border-gray-300 shadow">

                                                    <thead class="bg-blue-800 text-white">
                                                        <tr>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                UNIKL
                                                                DNA
                                                                Transferable Skills</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                Description</th>
                                                            <th class="py-3 px-4 text-center font-extrabold">
                                                                UniKL
                                                                DNA
                                                                Category Distribution</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody class="text-gray-800">
                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Self Awareness &
                                                                Integrity (SC 1)</td>
                                                            <td class="py-3 px-4 font-bold">Having good values
                                                                that
                                                                are honest, courageous, confident yet humble,
                                                                high
                                                                integrity and responsibility.</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Active Programme</li>
                                                                    <li>Sports & Recreation</li>
                                                                    <li>Leadership</li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Communication
                                                                Skills & Professional Sociability (SC 2)</td>
                                                            <td class="py-3 px-4 font-bold">Able to express
                                                                their
                                                                though clearly, confidently and effectively in
                                                                appropriate ways by listening and interact
                                                                respectfully with others.</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Active Programme</li>
                                                                    <li>Sports & Recreation</li>
                                                                    <li>Global</li>
                                                                    <li>Graduate</li>
                                                                    <li>Leadership</li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Open Mindedness &
                                                                Lifelong Learning (SC 3)</td>

                                                            <td class="py-3 px-4 font-bold">Receptive to new
                                                                and
                                                                different ideas or the opinion of others and
                                                                don't
                                                                impose their belief on others by accepting all
                                                                of
                                                                life's perceptive and realities.</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Active Programme</li>
                                                                    <li>Sports & Recreation</li>
                                                                    <li>Global</li>
                                                                    <li>Graduate</li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Practical,
                                                                Scientific & Problem Solving Skills (SC 4)</td>
                                                            <td class="py-3 px-4 font-bold">Always looking
                                                                foward
                                                                to strive for excellent in working environment
                                                                and
                                                                also their life and community.</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Entrepreneur</li>
                                                                    <li>Graduate</li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                        <tr class="border-t">
                                                            <td class="py-3 px-4 font-bold">Entrepreneurial
                                                                Ability (SC 5)</td>
                                                            <td class="py-3 px-4 font-bold">Always creative and
                                                                optimistic with entrepreneurial mind set.</td>
                                                            <td class="py-3 px-4">
                                                                <ul class="list-disc ml-5">
                                                                    <li>Entrepreneur</li>
                                                                    <li>Leadership</li>
                                                                </ul>
                                                            </td>
                                                        </tr>

                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        @else
                            <p class="text-gray-600 mt-3">No points yet. Submit activities to start earning!</p>
                        @endif

                    </div>

            @endif
        </div>
    </div>
@endsection


<style>
    #scroll-container {
        position: sticky;
        top: 5rem;
        height: 500px;
    }

    .swap-container {
        transition: transform 0.5s ease, opacity 0.5s ease;
        z-index: 1;
        opacity: 0;
    }

    .swap-container.active {
        opacity: 1;
        z-index: 10;
        transform: scale(1.05);
    }

    .fade-item {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .fade-item.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const items = document.querySelectorAll(".fade-item");

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                } else {
                    entry.target.classList.remove("visible");
                }
            });
        }, {
            threshold: 0.2
        });

        items.forEach(item => observer.observe(item));
    });
</script>

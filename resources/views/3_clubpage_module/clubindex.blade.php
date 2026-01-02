@extends('layoutStyle.styling')
{{-- main page displaying all clubs on UniKLSKILL  --}}
@section('content')
    <div class="flex justify-center mt-5">
        <div class="w-10/12 bg-white p-6 rounded-lg shadow-md mb-10">

            <div class="flex justify-end mt-4 gap-4 border-b rounded-lg px-4 py-4">


                @auth
                    @if (Auth::user()->userRole === 'admin')
                        <a href="{{ route('club.request') }}"
                            class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            Manage Club Proposals
                        </a>

                        <a href="{{ route('club.create') }}"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                            Create Club
                        </a>
                    @elseif (Auth::user()->userRole === 'student')
                        <a href="{{ route('club.propose') }}"
                            class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">
                            Propose New Club
                        </a>
                    @endif
                @endauth
            </div>
            <h2 class="text-2xl font-bold text-center py-4">Explore All Clubs Available In UniKL MIIT</h2>
            <p class="text-1xl font-semibold mb-4 text-gray-600 text-center px-15">Connect with others and foster teamwork and leadership ability
                as a team via various club that is available in UniKL MIIT! Did not find the club you looking for? Request to create on now and become
                the High Committee of the club as the leader and embark on new journey together!
            </p>

            <div class="mt-6">
                @livewire('club-search')
            </div>
        </div>
    </div>
@endsection

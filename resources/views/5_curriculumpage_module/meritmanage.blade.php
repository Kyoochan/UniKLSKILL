@extends('layoutStyle.styling')
{{-- Secretary manage all submitted My Excellence proposal from student --}}
@section('content')
    <div class="min-h-screen bg-gray-100 py-10">

        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">

            <h1 class="text-3xl font-bold mb-6 text-center">Pending My Excellence Requests</h1>


            {{-- If no pending proposals --}}
            @if ($proposals->isEmpty())
                <div class="text-center py-10 text-gray-600">
                    No pending GHOCS proposals found.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-blue-800 text-center text-white ">
                                <th class="p-3 border">Student</th>
                                <th class="p-3 border">Title</th>
                                <th class="p-3 border">GHOCS</th>
                                <th class="p-3 border">DNA</th>
                                <th class="p-3 border">Level</th>
                                <th class="p-3 border">Submitted At</th>
                                <th class="p-3 border text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($proposals as $proposal)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border">{{ $proposal->user->name }}</td>
                                    <td class="p-3 border">{{ $proposal->title }}</td>
                                    <td class="p-3 border">{{ $proposal->ghocs_element }}</td>
                                    <td class="p-3 border">{{ $proposal->dna_category }}</td>
                                    <td class="p-3 border">{{ $proposal->level }}</td>
                                    <td class="p-3 border">{{ $proposal->created_at->format('d M Y') }}</td>

                                    <td class="p-3 border text-center">
                                        <a href="{{ route('merit.view', $proposal->id) }}"
                                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded">Pending
                                            for Approval</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @endif

            <a href="{{ route('curriculumPage.show') }}"
                class="mt-10 inline-block text-center bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600">
                Back to Curriculum Page
            </a>

        </div>

    </div>
@endsection

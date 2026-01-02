@extends('layoutStyle.styling')

@section('content')

<body>
    <style>
        @media print {
            /* Hide everything by default */
            body * {
                visibility: hidden;
            }

            /* Show only transcript content */
            #transcript-area, #transcript-area * {
                visibility: visible;
            }

            /* Position transcript at top */
            #transcript-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            /* Hide print button and back link */
            .no-print {
                display: none !important;
            }

            /* Optional: clean page breaks */
            table {
                page-break-inside: avoid;
            }
            h1, h2, h3 {
                page-break-after: avoid;
            }
        }
    </style>

    <div class="min-h-screen py-10 px-4 bg-gray-100">

        <div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl">

            {{-- WRAP TRANSCRIPT CONTENT --}}
            <div id="transcript-area" class="max-w-4xl mx-auto bg-white p-8 rounded-2xl">

                {{-- HEADER --}}
                <div class="text-center mb-6">
                    <h1 class="text-2xl font-bold text-gray-800 mb-1">GRADUATE HIGHER ORDER CRITICAL SKILLS SYSTEM (GHOCS)</h1>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">ACTIVITY SUMMARY - PARTIAL TRANSCRIPT</h2>
                </div>

                {{-- STUDENT INFO --}}
                <div class="mb-6 border-t border-b border-gray-300 py-4 px-6">
                    <div class="grid grid-cols-2 gap-4 text-gray-700">
                        <div><span class="font-semibold">Student Name:</span> {{ Auth::user()->name }}</div>
                        <div><span class="font-semibold">Student ID:</span> {{ Auth::user()->student_id }}</div>
                        <div><span class="font-semibold">Programme:</span> {{ Auth::user()->programme }}</div>
                        <div><span class="font-semibold">Institute:</span> MALAYSIAN INSTITUTE OF INFORMATION TECHNOLOGY</div>
                        <div><span class="font-semibold">IC No:</span> {{ Auth::user()->ic_no ?? 'Not Applicable' }}</div>
                        <div><span class="font-semibold">Date Issued:</span> {{ date('d M Y') }}</div>
                    </div>
                </div>

                {{-- APPROVED ACTIVITY --}}
                <div class="mb-6 border-b border-gray-300 pb-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Verified Activities Participation</h3>

                    <table class="w-full text-left border-collapse border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-3 text-center text-gray-800">No</th>
                                <th class="py-2 px-3 text-center text-gray-800">DNA Category</th>
                                <th class="py-2 px-3 text-center text-gray-800">Activity Title</th>
                                <th class="py-2 px-3 text-center text-gray-800">Achievement Level</th>
                                <th class="py-2 px-3 text-center text-gray-800">Date Verified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($approvedActivities as $activity)
                                <tr class="border-t border-gray-300">
                                    <td class="py-2 px-3 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-2 px-3 text-center">{{ $activity->dna_category }}</td>
                                    <td class="py-2 px-3 text-center font-semibold">{{ $activity->title }}</td>
                                    <td class="py-2 px-3 text-center">{{ $activity->achievement_level }}</td>
                                    <td class="py-2 px-3 text-center">{{ $activity->updated_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No approved activities yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- POINTS SUMMARY --}}
                <div class="mb-6 border-b border-gray-300 pb-10">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">Total GHOCS Point by Component</h3>
                    <table class="w-full text-left border-1 border-gray-300 border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-3 text-gray-800 text-center align-middle">Component</th>
                                <th class="py-2 px-3 text-gray-800 text-center align-middle">Points Earned</th>
                            </tr>
                        </thead>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">Skill Development</th>
                            <td class="py-2 px-3 text-center align-middle">{{ $studentPoints->skill_development }}</td>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">UniKL DNA</th>
                            <td class="py-2 px-3 text-center align-middle">{{ $studentPoints->dna_points }}</td>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">Excellence</th>
                            <td class="py-2 px-3 text-center align-middle">{{ $studentPoints->excellence_points }}</td>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">S.P.I.C.E.S Activity Domain</th>
                            <td class="py-2 px-3 text-center align-middle">
                                {{ $studentPoints->ghocs_spiritual + $studentPoints->ghocs_physical + $studentPoints->ghocs_intellectual + $studentPoints->ghocs_career + $studentPoints->ghocs_emotional + $studentPoints->ghocs_social }}
                            </td>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">Management Skills</th>
                            <td class="py-2 px-3 text-center align-middle">{{ $studentPoints->management_skills }}</td>
                        </tr>
                        <tr class="border-b border-gray-300">
                            <th class="py-2 px-3 font-semibold text-gray-700">Total Activities</th>
                            <td class="py-2 px-3 text-center align-middle">{{ $approvedActivities->count() }}</td>
                        </tr>
                        <tr>
                            <th class="py-2 px-3 font-bold text-gray-800">Cumulative GHOCS Points</th>
                            <td class="py-2 px-3 text-center align-middle font-bold text-gray-900">{{ $studentPoints->total_points }}</td>
                        </tr>
                    </table>
                </div>

                {{-- DNA TRANSFERABLE SKILLS --}}
                <div class="mb-6 border-b border-gray-300">
                    <h3 class="text-lg font-bold text-gray-800 mb-3">UniKL DNA Transferable Skills</h3>
                    <table class="w-full border-collapse">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-3 text-gray-800 text-center">Transferable Skills</th>
                                <th class="py-2 px-3 text-gray-800 text-center">Points Earned</th>
                                <th class="py-2 px-3 text-gray-800 text-center">Percentage (%)</th>
                            </tr>
                        </thead>
                        @php
                            $scList = [
                                'SC1' => 'Self Awareness and Integrity',
                                'SC2' => 'Communication Skills and Professional  Sociability',
                                'SC3' => 'Open Mindedness and Lifelong Learning)',
                                'SC4' => 'Practical, Scientific and Problem Solving Skills',
                                'SC5' => 'Entrepreneurial Ability',
                            ];

                            $totalDNA = $studentPoints->SC1 + $studentPoints->SC2 + $studentPoints->SC3 + $studentPoints->SC4 + $studentPoints->SC5;
                        @endphp
                        @foreach ($scList as $scCode => $scName)
                            @php
                                $value = $studentPoints->$scCode;
                                $percent = $totalDNA > 0 ? round(($value / $totalDNA) * 100, 2) : 0;
                            @endphp
                            <tr class="border-b border-gray-200">
                                <td class="py-2 px-3 text-gray-700">{{ $scName }} ({{ $scCode }})</td>
                                <td class="py-2 px-3 text-gray-700 text-center align-middle">{{ $value }}</td>
                                <td class="py-2 px-3 text-gray-700 text-center align-middle">{{ $percent }}%</td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="mb-8">
                        <div class="w-full h-96 bg-white border-0 p-4">
                            <canvas id="dnaRadarChart"></canvas>
                        </div>
                    </div>
                </div>

            </div> {{-- END transcript-area --}}

            {{-- PRINT BUTTON --}}
            <div class="text-center mt-10 no-print">
                <button onclick="window.print()"
                    class="px-6 py-3 bg-blue-700 text-white font-semibold rounded-lg hover:bg-blue-800 transition">
                    Print Transcript
                </button>
            </div>

            {{-- BACK BUTTON --}}
            <div class="mt-10 no-print">
                <a href="{{ route('curriculumPage.show') }}"
                    class="mt-40 bg-orange-400 text-white px-6 py-3 rounded-lg hover:bg-orange-500 flex-1 text-center">
                    Back to Curriculum Page
                </a>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const scLabels = [
            @foreach ($scList as $scCode => $scName)
                "{{ $scName }}",
            @endforeach
        ];

        const scValues = [
            @foreach ($scList as $scCode => $scName)
                {{ $studentPoints->$scCode }},
            @endforeach
        ];

        const ctxRadar = document.getElementById('dnaRadarChart').getContext('2d');

        const radarChart = new Chart(ctxRadar, {
            type: 'radar',
            data: {
                labels: scLabels,
                datasets: [{
                    label: 'Points',
                    data: scValues,
                    backgroundColor: 'rgba(99,102,241,0.2)',
                    borderColor: 'rgba(99,102,241,1)',
                    pointBackgroundColor: 'rgba(79,70,229,1)',
                    pointBorderColor: '#fff',
                    pointHoverBackgroundColor: '#fff',
                    pointHoverBorderColor: 'rgba(79,70,229,1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    r: {
                        angleLines: { display: true },
                        suggestedMin: 0,
                        suggestedMax: 5,
                        ticks: { stepSize: 10, backdropColor: 'transparent' },
                        pointLabels: { font: { size: 14 } }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.formattedValue + ' points';
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
@endsection

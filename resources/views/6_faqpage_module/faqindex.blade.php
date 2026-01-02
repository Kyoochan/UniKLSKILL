@extends('layoutStyle.styling')

@section('content')
    <!-- Section 1 -->
    <div class="bg-orange-400 h-60 flex flex-col items-center justify-center px-6 text-center">
        <h1 class="text-white text-4xl font-bold mt-10 fade-item">
            UNIKL GHOCS
        </h1>
        <p class="text-white text-lg leading-relaxed max-w-3xl mb-10 fade-item">
            Graduate – Higher Order Critical Skills (G-HOCS) is a system developed to recognise student’s
            achievements and efforts through certification. The achievement and effort involve experiential
            learning in training and interaction sessions and activities outside or inside the classroom. Thus
            at the end your study, you will receive two certificates: one for your academic achievement and one
            for your extra-curricular achievement which highlights the soft-skill development that you have
            experienced.
        </p>
    </div>

    <!-- Section 2 -->
    <div class="w-full bg-white py-16">
        <h2 class="text-4xl font-bold text-center text-indigo-700 mb-12 fade-item">
            WHY GHOCS?
        </h2>

        <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 px-6">

            <!-- CARD 1 -->
            <div class="fade-item bg-indigo-50 p-6 rounded-xl shadow">
                <h3 class="text-xl text-center font-bold text-indigo-700 mb-3">
                    Holistic Growth & Discipline
                </h3>
                <p class="text-gray-700 leading-relaxed text-justify">
                    GHOCS encourages students not just to focus on academics, but also to build character, leadership,
                    teamwork, and other “higher-order” critical skills.
                </p>
            </div>

            <!-- CARD 2 -->
            <div class="fade-item bg-indigo-50 p-6 rounded-xl shadow">
                <h3 class="text-xl text-center font-bold text-indigo-700 mb-3">
                    Recognition of Non-Academic Achievement
                </h3>
                <p class="text-gray-700 leading-relaxed text-justify">
                    Through GHOCS, your extracurricular efforts are validated. This means when you graduate, you don’t just
                    have a degree; you also have a certificate (or transcript) that shows what soft skills you’ve built.
                </p>
            </div>

            <!-- CARD 3 -->
            <div class="fade-item bg-indigo-50 p-6 rounded-xl shadow">
                <h3 class="text-center text-xl font-bold text-indigo-700 mb-3">
                    E-Portfolio / Resume Ready
                </h3>
                <p class="text-gray-700 leading-relaxed text-justify">
                    The e-portfolio or transcript generated can act like an “e-resume” — helping you present your entire
                    university experience (not just grades) when you apply for jobs or internships.
                </p>
            </div>

        </div>
    </div>
    <!-- Section 3 -->
    <div class="w-full bg-yellow-500 py-16  ">
        <h2 class="text-4xl font-bold text-center text-yellow-900 mb-12 fade-item">
            STEPS TO EARN GHOCS FOR YOUR TRANSCRIPT
        </h2>
        <div x-data="{ step: 1 }" class="max-w-4xl mx-auto fade-item">

            <div class="flex justify-between items-center relative mt-10 ">

                <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10"></div>
                <template x-for="i in 5">
                    <button @click="step = i" class="flex flex-col items-center"
                        :class="step === i ? 'text-orange-600' : 'text-gray-400'">

                        <div class="w-40 h-20 rounded-t-lg flex justify-center items-center text-white font-bold transition
                            cursor-pointer"
                            :class="step === i ? 'bg-orange-500 scale-110 shadow-lg' : 'bg-gray-400 hover:bg-gray-500'">
                            <span class="text-sm font-semibold mt-2" x-text="'Step ' + i">
                            </span>
                        </div>
                    </button>
                </template>
            </div>

            <!-- CONTENT BOX -->
            <div class="bg-white p-6  shadow-lg min-h-[160px] transition-opacity duration-500 rounded-b-lg mb-10"
                :class="{ 'opacity-0': false }">

                <div x-show="step === 1" x-transition.opacity>
                    <h2 class="text-xl font-bold text-orange-600 mb-2">LOGIN TO START</h2>
                    <p>Sign up or login into an existing account to get started. Navigate to</p>
                </div>

                <div x-show="step === 2" x-transition.opacity>
                    <h2 class="text-xl font-bold text-orange-600 mb-2">PARTICIPATE IN ACTIVITIES</h2>
                    <p>Join clubs to have access to the club's GHOCS claimable activities. From time-to-time navigate to
                        News
                        section to see if there is any GHOCS claimable non-club activities there. You can identify GHOCS
                        claimable
                        activities by looking at the badges underneath the respective activities. </p>
                </div>

                <div x-show="step === 3" x-transition.opacity>
                    <h2 class="text-xl font-bold text-orange-600 mb-2">SUBMIT REQUEST FOR GHOCS</h2>
                    <p>Navigate to the GHOCS Program section and press submit My Excellence Request. Fill in the proposal
                        form
                        and proceed.</p>
                </div>

                <div x-show="step === 4" x-transition.opacity>
                    <h2 class="text-xl font-bold text-orange-600 mb-2">APPROVAL PROCESS</h2>
                    <p>Your submission will be reviewed based and verified by the secretaries. You will receive notification
                        whether your
                        submission is approved or not. If your submission is rejected, kindly review the remarks left if
                        any, on
                        the reasoning for the rejection. If your submission is approved, congratulations on the newly
                        acquired
                        GHOCS points!
                    </p>
                </div>

                <div x-show="step === 5" x-transition.opacity>
                    <h2 class="text-xl font-bold text-orange-600 mb-2">PRINT THE TRANSCRIPT</h2>
                    <p>You may print and review your transcript any time you want. Keep improving your radar chart to have
                        an
                        advantage for emploment.</p>
                </div>
            </div>

        </div>
    </div>



    <!-- Section 4 -->
    <div x-data="{ tab: 1 }" class="bg-indigo-600 py-10 px-6">
        <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">

            <div class="flex flex-col justify-center text-center lg:text-left">
                <h1 class="text-white  text-4xl font-bold mb-4 fade-item">
                    GHOCS HELP NURTURE STUDENTS WITH WORK-READY SKILLS
                </h1>
                <p class="text-gray-100 text-lg leading-relaxed fade-item text-justify">
                    Through UniKL DNA Transferable Skills program, it converts students GHOCS into radar chart
                    that can help graduates seeking employment as the transcript generated can be used as a supporting
                    evidence. Companies often look for more than just academic ability, the graduates ability to work
                    with
                    others and leadership skill are just some of the example of what GHOCS hopes to nurture. UniKL DNA
                    Transferable
                    Skills are the qualities company hope to find in graduates and thus the transcript can help boost
                    employability.
                </p>
            </div>

            <div class="flex flex-col space-y-3 ">

                <!-- TAB BUTTONS -->
                <div class="grid grid-cols-3 gap-3 fade-item">
                    <button @click="tab = 1" :class="tab === 1 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">
                        Skill Development Module
                    </button>

                    <button @click="tab = 2" :class="tab === 2 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">
                        UniKL DNA Program Component Module
                    </button>

                    <button @click="tab = 3" :class="tab === 3 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">
                        SPICES Activity Module
                    </button>

                    <button @click="tab = 4" :class="tab === 4 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">
                        My Excellence Module
                    </button>

                    <button @click="tab = 5" :class="tab === 5 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">
                        Management Skill Module
                    </button>

                    <button @click="tab = 6" :class="tab === 6 ? 'bg-white text-orange-600' : 'bg-orange-400 text-white'"
                        class="py-2 rounded-lg font-semibold shadow transition-all duration-300
           hover:bg-orange-500 hover:text-white px-1">

                        UniKL DNA Transferable Skills
                    </button>
                </div>

                <!-- TAB CONTENT -->
                <div class="bg-white p-6 rounded-xl shadow-lg min-h-[150px] fade-item">

                    <div x-show="tab === 1">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is Skill Development Module?</h2>
                        <p>Skill Development is a module that focus on continued learning even outside classrooms.
                            Students
                            can obtain Skill Development points via subjects listed under student development sections
                            such
                            as Languages and common General Subjects.</p>
                    </div>

                    <div x-show="tab === 2">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is UniKL DNA Program Component Module?
                        </h2>
                        <p>Each GHOCS claimable activity from clubs or news posted on UniKLSKILL each have a badge for
                            Activity Level category, DNA program category and SPICES Domain category. Each category of
                            DNA
                            Program Component contributes to building DNA Transferable Skills on student's radar chart
                            transcript when printing the transcript later on.</p>
                    </div>

                    <div x-show="tab === 3">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is SPICES Activity Module?</h2>
                        <p>Each activity conducted by students will fall under SIX domains classified as Spiritual (S),
                            Physical (P), Intellectual (I), Career (C), Emotion (E) and Social (S).SPICES are UniKL
                            Student
                            Development Model defined for all student activities as Student Character Building (SCB).
                            SPICES
                            is the heart in developing “holistic graduate” leading to student success, area of
                            development.
                        </p>
                    </div>

                    <div x-show="tab === 4">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is the Excellence Module?</h2>
                        <p>Excellence is a module to record student's achievement and convert it to points that will
                            contribute to the total cummulative GHOCS points. This module reward student's
                            accomplishment
                            during their academic years for making UniKL MIIT proud.</p>
                    </div>

                    <div x-show="tab === 5">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is Management Skill Module?</h2>
                        <p>Management Skills derive from the student's ability to manage either their time as a club
                            member
                            or
                            their ability to give commitment on managing one or several clubs as the club's High
                            Committee
                            Member. The more a student's able to join and manage clubs, the more points they can get.
                        </p>
                    </div>

                    <div x-show="tab === 6">
                        <h2 class="text-xl font-bold mb-2 text-orange-600">What is UniKL DNA Transferable Skills?</h2>
                        <p>UniKL DNA Points from UniKL DNA PRogram Component Module will be converted into UniKL DNA
                            Transferable Skills for your radar chart on
                            your printable GHOCS transcript. This radar chart is important as it highlights the level
                            of work-ready skills the student have learned.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
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


<script>
    const form = document.getElementById('faqForm');
    const messages = document.getElementById('messages');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const questionInput = document.getElementById('question');
        const question = questionInput.value.trim();
        if (!question) return;

        // Display user question
        const userMsg = document.createElement('div');
        userMsg.className = 'mb-2 text-right';
        userMsg.innerHTML =
            `<span class="inline-block bg-blue-100 text-blue-800 px-3 py-1 rounded">${question}</span>`;
        messages.appendChild(userMsg);

        questionInput.value = '';
        messages.scrollTop = messages.scrollHeight;

        // Send AJAX request
        const response = await fetch('{{ route('faqs.ask') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                question
            })
        });
        const data = await response.json();

        // Display bot response
        const botMsg = document.createElement('div');
        botMsg.className = 'mb-2 text-left';
        botMsg.innerHTML =
            `<span class="inline-block bg-gray-200 text-gray-800 px-3 py-1 rounded">${data.response}</span>`;
        messages.appendChild(botMsg);
        messages.scrollTop = messages.scrollHeight;
    });
</script>

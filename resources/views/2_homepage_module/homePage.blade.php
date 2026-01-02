@extends('layoutStyle.styling')

@section('content')
    <!--====================================== SECTION 1 ======================================-->

    <div class="fade-item absolute top-100 left-30 z-50 font-extrabold text-white font-sans text-9xl">
        <div class="bg-gray-800/50 backdrop-blur-md-3 rounded-xl p-6 inline-block text-center">
            <div class="text-gray-100">

            </div>
            <div class="border-b-2  pt-2">
                <span class="text-gray-100 inline-block">UniKL</span>
                <span class="text-orange-400">SKILL</span>
            </div>
        </div>
    </div>

    <!-- Rotating Image Section -->
    <div class="w-full my-0 relative">
        <div class="relative w-full h-64 md:h-150 overflow-hidden">

            <img src="{{ asset('images/homepage_img1.jpg') }}"
                class="slideshow-img absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-700">
            <img src="{{ asset('images/homepage_img2.jpg') }}"
                class="slideshow-img absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">
            <img src="{{ asset('images/homepage_img3.jpg') }}"
                class="slideshow-img absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">
            <img src="{{ asset('images/homepage_img4.jpeg') }}"
                class="slideshow-img absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">

            <button id="prevBtn"
                class="absolute top-1/2 left-4 -translate-y-1/2
           bg-orange-500 bg-opacity-80 text-white
           px-2 py-30 rounded
           hover:bg-orange-600 hover:bg-opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 5 l-7 7 7 7" />
                </svg>
            </button>

            <button id="nextBtn"
                class="absolute top-1/2 right-4 -translate-y-1/2
           bg-orange-500 bg-opacity-80 text-white
           px-2 py-30 rounded
           hover:bg-orange-600 hover:bg-opacity-90 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="7">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5 l7 7-7 7" />
                </svg>
            </button>


            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-3">
                <div class="indicator w-20 h-3 bg-black bg-opacity-40 rounded transition-all duration-300"></div>
                <div class="indicator w-20 h-3 bg-black bg-opacity-40 rounded transition-all duration-300"></div>
                <div class="indicator w-20 h-3 bg-black bg-opacity-40 rounded transition-all duration-300"></div>
                <div class="indicator w-20 h-3 bg-black bg-opacity-40 rounded transition-all duration-300"></div>
            </div>
        </div>
    </div>
    <div class="bg-orange-400 h-31 text-4xl flex items-center justify-center font-sans font-extrabold text-white">
        Empowering UniKL MIIT Students Through Co-Curricular Excellence

    </div>
    <!--====================================== SECTION 2 ======================================-->
    <div id="scroll-wrapper" class="relative w-full mt-0 h-[1500px] bg-cover"
        style="background-image: url('{{ asset('images/IMG_0321-anis-scaled.jpg') }}');
            background-position: -450px center;">


        <div id="scroll-container" class="sticky top-20 h-[500px]">

            <div class="swap-container absolute top-0 left-1/2 -translate-x-1/2 p-6 bg-orange-400 rounded-xl w-240 h-120 flex items-center justify-between"
                data-index="0">
                <div class="flex-1 pr-4 mb-10">
                    <h2 class="text-5xl font-extrabold py-4 text-gray-900 font-sans text-left">
                        FIND THOSE WHO SHARE YOUR INTEREST
                    </h2>
                    <p class="text-black-700 text-lg md:text-xl leading-relaxed font-sans text-justify">
                        Browse through UniKLSKILL's catalogue of clubs, all handled by students who share the same
                        interests—whether it's hobbies or sports. Didn't find one? Propose and lead
                        your very own club to connect with like-minded individual who share the same passion as yours!
                    </p>

                    <a href="{{ route('club.index') }}"
                        class="mt-5 inline-block px-6 py-3 bg-white/80 hover:bg-white text-orange-800 font-semibold
                                rounded-full  backdrop-blur-md transition duration-300">
                        Explore MIIT Clubs
                    </a>

                </div>
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/homepage_sec2img1.png') }}" alt="Sample Image"
                        class="rounded-lg w-100 h-100 object-cover shadow-lg">
                </div>
            </div>

            <div class="swap-container absolute top-0 left-1/2 -translate-x-1/2 p-6 bg-gray-100 rounded-xl w-240 h-120 flex items-center justify-between"
                data-index="1">
                <div class="flex-1 pr-4 mb-25">
                    <h2 class="text-5xl font-extrabold py-4 text-black  font-sans text-left">
                        COMPETE WITH OTHER CLUBS
                    </h2>
                    <p class="text-gray-700 text-lg md:text-xl leading-relaxed font-sans text-justify">
                        Take part in club activities and participates in events to
                        represents UniKL MIIT. UniKLSKILL is there to keep you
                        updated whether it is club announcement or upcoming events!
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/homepage_sec2img2.png') }}" alt="Sample Image"
                        class="rounded-lg w-100 h-100 object-cover ">
                </div>
            </div>
            <div class="swap-container absolute top-0 left-1/2 -translate-x-1/2 p-6 bg-blue-900 rounded-xl w-240 h-120 flex items-center justify-between"
                data-index="2">
                <div class="flex-1 pr-4 mb-25">
                    <h2 class="text-5xl font-extrabold py-4 text-white font-sans text-left">
                        CATALOGUE YOUR ACHIEVEMENT WITH UNIKLSKILL
                    </h2>
                    <p class="text-white text-lg md:text-xl leading-relaxed font-sans text-justify ">
                        Convert your achievement
                        and contribution during your academic years into GHOCS to support your job interview.
                        Be rewarded from making UniKL MIIT proud!
                    </p>
                    <a href="{{ route('faqPage.show') }}"
                        class="mt-5 inline-block px-6 py-3 bg-white/80 hover:bg-white text-black font-semibold
                                rounded-full  backdrop-blur-md transition duration-300">
                        Learn more about GHOCS
                    </a>
                </div>
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/homepage_sec2img3.jpeg') }}" alt="Sample Image"
                        class="rounded-lg w-100 h-100 object-cover ">
                </div>
            </div>
        </div>
    </div>

    <!--====================================== SECTION 3 ======================================-->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <div class="w-full bg-blue-900 py-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-start px-6">

            <div class="flex justify-center fade-item">
                <img src="{{ asset('images/mascot_1.png') }}" alt="Section Image"
                    class="w-90 h-90 rounded-full shadow-lg bg-orange-400 object-cover"
                    style="object-position: -81px 30px;">
            </div>

            <div class="fade-item">
                <div x-data="{ open: false }" class="text-white">
                    <h2 @click="open = !open"
                        class="text-4xl font-bold mb-4 cursor-pointer hover:text-orange-400 transition">
                        UniKLSKILL's Vision and Objective
                    </h2>

                    <div x-show="open" x-transition class="text-lg leading-relaxed opacity-90 text-justify">
                        The objectives is to better shape its students into highly skilled graduates sought after by the
                        industry. UniKLSKILL exist to help UniKL MIIT students to stay updated and actives in co-curricular
                        activities during their academic year as a student.
                    </div>
                </div>

                <div x-data="{ open: false }" class="fade-item text-white border-t-2 border-white pt-6 mt-6">
                    <h2 @click="open = !open"
                        class="text-4xl font-bold mb-4 cursor-pointer hover:text-orange-400 transition">
                        UniKLSKILL relation with GHOCS system
                    </h2>

                    <div x-show="open" x-transition class="text-lg leading-relaxed opacity-90 text-justify">
                        UniKLSKILL hopes to motivate students to actively participate and record their achievement during
                        their time as a UniKL MIIT students to be converted into GHOCS points by making it easier to do so
                        compared to existing system in Ecitie. UniKLSKILL ease the GHOCS proposal from student side and
                        guide while also be transparent on how to get their desired DNA Transferable Skills on the Radar
                        Chart when printing the total accumulated GHOCS points.
                    </div>
                </div>

                <div x-data="{ open: false }" class="fade-item text-white border-t-2 border-white pt-6 mt-6">
                    <h2 @click="open = !open"
                        class="text-4xl font-bold mb-4 cursor-pointer hover:text-orange-400 transition">
                        Importance of GHOCS Towards Student
                    </h2>

                    <div x-show="open" x-transition class="text-lg leading-relaxed opacity-90 text-justify">
                        GHOCS is a system developed to provide recognition of student's achievements outside of classroom.
                        GHOCS was proposed to reduce the competency gap highlighted in the employability by becoming a
                        supporting transcript during interview. It is important that UniKL students especially MIIT's
                        students to also focus on filling and widening the area coverage of the radar chart produced by the
                        transcript.
                        UniKLSKILL hopes to serve as central highlights to show MIIT students that even without dedicated
                        facilites or building to held
                        sports, MIIT's co-curricular scene is as active as other universities.
                    </div>
                </div>
                <div x-data="{ open: false }" class="fade-item text-white border-t-2 border-white pt-6 mt-6">
                    <h2 @click="open = !open"
                        class="text-4xl font-bold mb-4 cursor-pointer hover:text-orange-400 transition">
                        Get Started With UniKLSKILL
                    </h2>

                    <div x-show="open" x-transition class="text-lg leading-relaxed opacity-90 text-justify">
                        Start by register an account in UniKLSKILL system to get started. Connect with other
                        MIIT students who share the same passion as you and track your GHOCS to graduate as a
                        holistic students ready for employment.

                        @guest
                            <a href="{{ route('register.show') }}"
                                class="mt-5 inline-block px-6 py-3 bg-white/80 hover:bg-white text-black font-semibold
              rounded-full backdrop-blur-md transition duration-300">
                                Register Now
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Section 1 script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll(".slideshow-img");
        const indicators = document.querySelectorAll(".indicator");

        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");

        let index = 0;

        function showImage(i) {
            images.forEach((img, idx) => {
                img.style.opacity = (idx === i) ? 1 : 0;
            });

            indicators.forEach((dot, idx) => {
                if (idx === i) {
                    dot.classList.remove("bg-black");
                    dot.classList.add("bg-orange-500");
                    dot.classList.add("bg-opacity-100");
                } else {
                    dot.classList.remove("bg-orange-500");
                    dot.classList.add("bg-black");
                    dot.classList.add("bg-opacity-40");
                }
            });
        }


        nextBtn.addEventListener("click", () => {
            index = (index + 1) % images.length;
            showImage(index);
        });

        prevBtn.addEventListener("click", () => {
            index = (index - 1 + images.length) % images.length;
            showImage(index);
        });

        // Auto-rotate
        setInterval(() => {
            index = (index + 1) % images.length;
            showImage(index);
        }, 6000);

        showImage(index);
    });
</script>

{{-- Section 2 script --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const swapContainers = document.querySelectorAll(".swap-container");
        const scrollContainer = document.getElementById("scroll-container");

        scrollContainer.addEventListener("scroll", () => {
            const scrollTop = scrollContainer.scrollTop;
            const containerHeight = scrollContainer.clientHeight;

            swapContainers.forEach(container => {
                const index = parseInt(container.getAttribute("data-index"));
                const containerOffsetTop = container.offsetTop;
                const distance = Math.abs(scrollTop + containerHeight / 2 - (
                    containerOffsetTop + container.clientHeight / 2));

                if (distance < containerHeight / 2) {
                    container.style.transform = "scale(1.05)";
                    container.style.boxShadow = "0 10px 20px rgba(0, 0, 0, 0.2)";
                } else {
                    container.style.transform = "scale(1)";
                    container.style.boxShadow = "none";
                }
            });
        });
    });
</script>

{{-- Section 1 script --}}
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const containers = document.querySelectorAll('.swap-container');
        const wrapper = document.getElementById('scroll-wrapper');
        const containerCount = containers.length;

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const wrapperTop = wrapper.offsetTop;
            const wrapperHeight = wrapper.offsetHeight;
            const viewportHeight = window.innerHeight;

            let progress = (scrollTop - wrapperTop) / (wrapperHeight - viewportHeight);
            progress = Math.min(Math.max(progress, 0), 1);

            const index = Math.min(Math.floor(progress * containerCount), containerCount - 1);

            containers.forEach((container, i) => {
                if (i < index) {
                    container.classList.remove('active');
                    container.style.transform = 'scale(1) translateY(-20px)';
                    container.style.zIndex = 1;
                    container.style.opacity = 0.6;
                } else if (i === index) {
                    container.classList.add('active');
                    container.style.transform = 'scale(1.05) translateY(0)';
                    container.style.zIndex = 10;
                    container.style.opacity = 1;
                } else {
                    container.classList.remove('active');
                    container.style.transform = 'scale(1) translateY(20px)';
                    container.style.zIndex = 1;
                    container.style.opacity = 0;
                }
            });
        });
    });
</script>

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

@extends('layoutStyle.styling')

@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!--====================================== SECTION 1 ======================================-->

<div class="position-absolute top-100 start-30 text-white fw-bold display-1" style="z-index:50;">
    <div class="bg-dark bg-opacity-50 rounded-3 p-4 text-center" style="backdrop-filter: blur(3px);">
        <div class="border-bottom border-light pb-2">
            <span class="text-white">UniKL</span>
            <span class="text-warning">SKILL</span>
        </div>
    </div>
</div>

<!-- Rotating Image Section -->
<div class="w-100 position-relative my-0">
    <div class="position-relative w-100" style="height: 25rem; overflow:hidden;">
        <div id="carouselExampleFade" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
            <div class="carousel-inner h-100">
                <div class="carousel-item active h-100">
                    <img src="{{ asset('images/homepage_img1.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                </div>
                <div class="carousel-item h-100">
                    <img src="{{ asset('images/homepage_img2.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                </div>
                <div class="carousel-item h-100">
                    <img src="{{ asset('images/homepage_img3.jpg') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                </div>
                <div class="carousel-item h-100">
                    <img src="{{ asset('images/homepage_img4.jpeg') }}" class="d-block w-100 h-100 object-fit-cover" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bg-warning rounded-circle p-2"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                <span class="carousel-control-next-icon bg-warning rounded-circle p-2"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</div>

<div class="bg-warning text-white text-center py-3 fw-bold fs-4">
    Empowering UniKL MIIT Students Through Co-Curricular Excellence
</div>

<!--====================================== SECTION 2 ======================================-->
<div id="scroll-wrapper" class="position-relative w-100 mt-0" style="height:1500px; background-image: url('{{ asset('images/IMG_0321-anis-scaled.jpg') }}'); background-position: -450px center; background-size: cover;">
    <div id="scroll-container" class="position-sticky top-20" style="height:500px;">

        <div class="swap-container card position-absolute top-0 start-50 translate-middle-x p-4 bg-warning text-dark rounded-3" data-index="0" style="width: 60%; height: 25rem;">
            <div class="row h-100 align-items-center">
                <div class="col-md-7">
                    <h2 class="fw-bold display-5">FIND THOSE WHO SHARE YOUR INTEREST</h2>
                    <p>Browse through UniKLSKILL's catalogue of clubs, all handled by students who share the same interests—whether it's hobbies or sports. Didn't find one? Propose and lead your very own club to connect with like-minded individuals who share the same passion as yours!</p>
                    <a href="{{ route('club.index') }}" class="btn btn-light text-warning fw-bold mt-3">Explore MIIT Clubs</a>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('images/homepage_sec2img1.png') }}" alt="Sample Image" class="img-fluid rounded shadow">
                </div>
            </div>
        </div>

        <div class="swap-container card position-absolute top-0 start-50 translate-middle-x p-4 bg-light text-dark rounded-3" data-index="1" style="width: 60%; height: 25rem;">
            <div class="row h-100 align-items-center">
                <div class="col-md-7">
                    <h2 class="fw-bold display-5">COMPETE WITH OTHER CLUBS</h2>
                    <p>Take part in club activities and participate in events representing UniKL MIIT. UniKLSKILL keeps you updated with announcements and upcoming events!</p>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('images/homepage_sec2img2.png') }}" alt="Sample Image" class="img-fluid rounded">
                </div>
            </div>
        </div>

        <div class="swap-container card position-absolute top-0 start-50 translate-middle-x p-4 bg-primary text-white rounded-3" data-index="2" style="width: 60%; height: 25rem;">
            <div class="row h-100 align-items-center">
                <div class="col-md-7">
                    <h2 class="fw-bold display-5">CATALOGUE YOUR ACHIEVEMENT WITH UNIKLSKILL</h2>
                    <p>Convert your achievements and contributions during your academic years into GHOCS points. Be rewarded for making UniKL MIIT proud!</p>
                    <a href="{{ route('faqPage.show') }}" class="btn btn-light text-dark fw-bold mt-3">Learn more about GHOCS</a>
                </div>
                <div class="col-md-5">
                    <img src="{{ asset('images/homepage_sec2img3.jpeg') }}" alt="Sample Image" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </div>
</div>

<!--====================================== SECTION 3 ======================================-->
<div class="bg-primary py-5">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center">
                <img src="{{ asset('images/mascot_1.png') }}" alt="Section Image" class="rounded-circle shadow-lg bg-warning" style="width: 15rem; height: 15rem; object-fit: cover; object-position: -81px 30px;">
            </div>
            <div class="col-md-6 text-white">
                <div class="accordion" id="visionAccordion">

                    <div class="accordion-item bg-transparent border-light">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                UniKLSKILL's Vision and Objective
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#visionAccordion">
                            <div class="accordion-body text-white-50">
                                The objective is to shape students into highly skilled graduates sought after by industry. UniKLSKILL helps students stay active in co-curricular activities.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-light">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                UniKLSKILL relation with GHOCS system
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#visionAccordion">
                            <div class="accordion-body text-white-50">
                                UniKLSKILL motivates students to actively participate and record achievements to convert into GHOCS points easily, guiding them on transferable skills on the Radar Chart.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-light">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Importance of GHOCS Towards Student
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#visionAccordion">
                            <div class="accordion-body text-white-50">
                                GHOCS provides recognition for student achievements outside the classroom, supporting employability and showcasing co-curricular activity.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item bg-transparent border-light">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed bg-transparent text-white fw-bold fs-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Get Started With UniKLSKILL
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#visionAccordion">
                            <div class="accordion-body text-white-50">
                                Register an account, connect with other MIIT students, and track your GHOCS points.
                                @guest
                                <a href="{{ route('register.show') }}" class="btn btn-light text-dark fw-bold mt-3">Register Now</a>
                                @endguest
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

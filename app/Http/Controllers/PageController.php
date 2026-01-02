<?php

namespace App\Http\Controllers;

class PageController extends Controller
{
    public function displayHome()
    {
        return view('2_homepage_module.homePage');
    }

    public function displayClub()
    {
        return view('3_clubpage_module.clubindex');
    }

    public function displayNews()
    {
        return view('4_newspage_module.newsindex');
    }

    public function displayCurriculum()
    {
        $studentPoints = null;

        if (auth()->check() && auth()->user()->userRole === 'student') {
            $studentPoints = \App\Models\StudentPoint::firstOrCreate(
                ['user_id' => auth()->id()],
                ['issued_date' => now()]
            );
        }

        return view('5_curriculumpage_module.curriculumindex', compact('studentPoints'));
    }



    public function displayFaq()
    {
        return view('6_faqpage_module.faqindex');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        return view('faqindex'); // Your Blade view
    }

    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question = strtolower($request->question);
        $faqs = Faq::all();

        $response = "Sorry, I don't understand your question. If you need hints of keywords, type 'hint' or 'tips' or 'suggestions'. If you need further assistance, please contact the UniKLSKILL Helpdesk at helpdesk@gmail.com or call 01139280378 during office hours. We are here to help you!";

        foreach ($faqs as $faq) {
            $keywords = explode(',', strtolower($faq->keywords));
            foreach ($keywords as $keyword) {
                if (strpos($question, trim($keyword)) !== false) {
                    $response = $faq->response;
                    break 2;
                }
            }
        }

        return response()->json(['response' => $response]);
    }
}

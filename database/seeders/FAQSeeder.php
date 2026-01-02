<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//Seeder for populating the FAQs table with initial data (Manual training FAQ Chatbot)
class FAQSeeder extends Seeder
{
    public function run()
    {
        DB::table('faqs')->insert([
            [
                'keywords' => 'hello,hey',
                'response' => 'Hello! I am the UniKLSKILL FAQ Bot. If you have  question about clubs, type the word "clubs". For news, type "news". How can I assist you today?',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'clubs,club,clubs info',
                'response' => 'You can view all clubs and join them via the Club page. You have to create an account and log in first before you can join any club. Student can request new club proposal if the club you want doesnt exist in the UniKLSKILL system. Any inquiries about the clubs membership process type the word "membership".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'membership,join club,how to join',
                'response' => 'To join a club, navigate to the Club page, select the club you are interested in, and click the "Join Club" button and wait until the club advisor or High Committee to approve your request. Question about club activity process type the word "activity".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'activity,club activity,events',
                'response' => 'You can view upcoming club activities and non-club activities on the News page. Only club members can view discussion of the club activities. Club activities and non-club activities are GHOCS claimable. For questions about GHOCS type the word "GHOCS".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'GHOCS,ghocs,claim, ghoc',
                'response' => 'GHOCS points can be claimed through the GHOCS Claim page after participating in club activities or non-club activities. Make sure to follow the guidelines for claiming GHOCS points. You can learn more about GHOCS on the GHOCS page if you have an account, or go to FAQ page for a brief summary of the process.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'news,updates,announcement',
                'response' => 'You can check the latest news on the News page. Sometimes there is GHOCS claimable non-club activities announced there. Student can claim GHOCS points after participating in those activities. For questions about GHOCS type the word "GHOCS".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'help,support,assist',
                'response' => 'If you need hints of keywords, type "hint" or "tips" or "suggestions". If you need further assistance, please contact the UniKLSKILL Helpdesk at helpdesk@gmail.com or call 01139280378 during office hours. We are here to help you!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'keywords' => 'hint,tips,suggestions',
                'response' => 'Here are some keywords you can use to get information: "clubs", "membership", "activity", "GHOCS", "news", "help". Type the word related to your question to get started!',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

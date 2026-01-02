<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Migration to add PDF proposal, budget, and additional description to proposal_news table (missing during initial proposal_news migration)
return new class extends Migration {
    public function up(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            $table->string('proposal_pdf')->nullable()->after('image');
            $table->decimal('budget', 15, 2)->nullable()->after('proposal_pdf');
            $table->text('additional_description')->nullable()->after('budget');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            $table->dropColumn(['proposal_pdf', 'budget', 'additional_description']);
        });
    }
};

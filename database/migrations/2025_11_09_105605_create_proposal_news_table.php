<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Migration to create the proposal_news table (For student, advisors to propose news articles for SDCL to approve and publish)
return new class extends Migration {
    public function up(): void
    {
        Schema::create('proposal_news', function (Blueprint $table) {
            $table->id();
            $table->string('proposal_news_name');
            $table->text('proposal_news_description');
            $table->string('image')->nullable();
            $table->string('ghocs_element')->nullable();
            $table->string('level')->nullable();
            $table->string('location')->nullable();
            $table->string('dna_category')->nullable();
            $table->date('activity_date')->nullable();
            $table->date('activity_date_end')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('proposal_news');
    }
};

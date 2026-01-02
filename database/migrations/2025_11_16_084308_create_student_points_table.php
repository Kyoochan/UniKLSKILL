<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to create the student_points table (to track accumulated GHOCS)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('student_points', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');

    //skill development
    $table->integer('skill_development')->default(0);

    // DNA categories(UniKL DNA)
    $table->integer('dna_active_programme')->default(0);
    $table->integer('dna_sports_recreation')->default(0);
    $table->integer('dna_entrepreneur')->default(0);
    $table->integer('dna_global')->default(0);
    $table->integer('dna_graduate')->default(0);
    $table->integer('dna_leadership')->default(0);

    // Achievement (Excellence)
    $table->integer('achievement_representative')->default(0);
    $table->integer('achievement_participate')->default(0);
    $table->integer('achievement_special_award')->default(0);
    $table->integer('achievement_international_short')->default(0);
    $table->integer('achievement_international_full')->default(0);
    $table->integer('achievement_exchange_short')->default(0);
    $table->integer('achievement_exchange_full')->default(0);

    // GHOCS elements (personal display)
    $table->integer('ghocs_spiritual')->default(0);
    $table->integer('ghocs_physical')->default(0);
    $table->integer('ghocs_intellectual')->default(0);
    $table->integer('ghocs_career')->default(0);
    $table->integer('ghocs_emotional')->default(0);
    $table->integer('ghocs_social')->default(0);

    //Management Skills
    $table->integer('management_skills')->default(0);

    //Issued Date
    $table->date('issued_date')->nullable();

    $table->timestamps();
});

}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_points');
    }
};

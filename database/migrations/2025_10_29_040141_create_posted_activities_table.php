<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to create the 'posted_activities' table (for activities that have been posted based on approved proposals)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('posted_activities', function (Blueprint $table) {
        $table->id();
        $table->foreignId('proposal_id')->constrained('activity_proposals')->onDelete('cascade');
        $table->foreignId('club_id')->constrained('clubs')->onDelete('cascade');
        $table->string('activity_title');
        $table->text('activity_description');
        $table->json('images')->nullable();
        $table->timestamp('posted_at')->useCurrent();
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posted_activities');
    }
};

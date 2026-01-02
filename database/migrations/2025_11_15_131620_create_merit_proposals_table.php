<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to create the merit_proposals table (for student-submitted GHOCS request)
return new class extends Migration
{
    public function up()
    {
        Schema::create('merit_proposals', function (Blueprint $table) {
            $table->id();

            // Student submitting the merit proposal
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Optional reference to activity/news
            $table->string('reference_type')->nullable(); // 'activity', 'news'
            $table->unsignedBigInteger('reference_id')->nullable();

            // Activity details (manual or auto-filled)
            $table->string('title');
            $table->string('ghocs_element');
            $table->string('level');
            $table->string('dna_category');
            $table->date('activity_date')->nullable();

            // Required
            $table->string('achievement_level');
            $table->text('description');

            // Evidence file
            $table->string('evidence');

            // Status system
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // Admin comment for rejection
            $table->text('admin_comment')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('merit_proposals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('skill_proposals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // who submits
            $table->string('title'); // proposal title
            $table->string('pdf_file'); // uploaded PDF path
            $table->string('subject_name'); // selected subject name
            $table->integer('subject_points'); // points of selected subject
            $table->enum('approval_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('secretary_remark')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skill_proposals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to create the club_proposals table (Student Club Proposals for SDCL to approve/reject)
return new class extends Migration
{
    public function up(): void
{
    Schema::create('club_proposals', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('student_id')->index();
    $table->string('clubname');
    $table->text('clubdesc');
    $table->string('proposal_pdf');
    $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
    $table->timestamps();

    $table->foreign('student_id')
          ->references('id')
          ->on('users')
          ->onDelete('cascade');
});
}


    public function down(): void
    {
        Schema::dropIfExists('club_proposals');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to create the proposal_templates table (stores club proposal template files that SDLC manages/updates from time to time)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('proposal_templates', function (Blueprint $table) {
        $table->id();
        $table->string('file_name');
        $table->string('file_path');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('proposal_templates');
}

};

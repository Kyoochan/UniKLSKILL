<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to add 'status' column to 'proposal_news' table (missing in previous migration)
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            $table->string('status')->default('pending')->after('additional_description');
        });
    }

    public function down(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

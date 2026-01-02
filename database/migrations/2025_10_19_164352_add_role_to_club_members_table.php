<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//Migration for adding role column to club_members table (missing during initial creation of club_members table)
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('club_members', function (Blueprint $table) {
            $table->enum('role', ['leader', 'treasurer', 'secretary','multimedia', 'sponsorship', 'logistic'])->nullable()->after('position');
        });
    }

    public function down(): void
    {
        Schema::table('club_members', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};

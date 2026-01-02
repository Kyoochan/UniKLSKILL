<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to add new fields to the posted_activities table (missing during initial activity_proposal migration)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posted_activities', function (Blueprint $table) {
            $table->date('activity_date')->nullable()->after('activity_description');
            $table->date('activity_date_end')->nullable()->after('activity_date');
            $table->string('level')->nullable()->after('activity_date_end');
            $table->string('dna_category')->nullable()->after('level');
            $table->string('ghocs_element')->nullable()->after('dna_category');
            $table->string('location')->nullable()->after('ghocs_element');
            $table->text('budget')->nullable()->after('location');
            $table->text('additional_info')->nullable()->after('budget');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posted_activities', function (Blueprint $table) {
            $table->dropColumn([
                'activity_date',
                'activity_date_end',
                'level',
                'dna_category',
                'ghocs_element',
                'location',
                'budget',
                'additional_info',
            ]);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 *  Migration to add new fields to activity_proposals table
 * (add type of activity and other details caues missing during activity proposal creation migration)
 * */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('activity_proposals', function (Blueprint $table) {

            $table->date('activity_date_end')->nullable()->after('activity_date');

            $table->string('level')->nullable()->after('activity_date_end');
            $table->string('dna_category')->nullable()->after('level');
            $table->string('ghocs_element')->nullable()->after('dna_category');

            $table->string('location')->nullable()->after('ghocs_element');
            $table->text('budget')->nullable()->after('location');
            $table->text('additional_info')->nullable()->after('budget');
        });
    }

    public function down(): void
    {
        Schema::table('activity_proposals', function (Blueprint $table) {

            $table->dropColumn([
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

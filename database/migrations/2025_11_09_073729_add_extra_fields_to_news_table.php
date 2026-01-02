<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


// Migration to add extra fields to the news table (missing during initial news migration)
return new class extends Migration {
    public function up(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->string('ghocs_element')->nullable()->after('published_at');
            $table->string('level')->nullable()->after('ghocs_element');
            $table->string('location')->nullable()->after('level');
            $table->string('dna_category')->nullable()->after('location');
            $table->date('activity_date')->nullable()->after('dna_category');
            $table->date('activity_date_end')->nullable()->after('activity_date');
        });
    }

    public function down(): void
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn([
                'ghocs_element',
                'level',
                'location',
                'dna_category',
                'activity_date',
                'activity_date_end',
            ]);
        });
    }
};

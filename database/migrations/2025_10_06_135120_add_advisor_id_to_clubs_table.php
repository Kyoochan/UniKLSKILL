<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//Migration for adding advisor_id to clubs table (Advisor is missing during initial clubs table creation)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('clubs', function (Blueprint $table) {
        $table->unsignedBigInteger('advisor_id')->nullable()->after('clubdesc');
        $table->foreign('advisor_id')->references('id')->on('users')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('clubs', function (Blueprint $table) {
        $table->dropForeign(['advisor_id']);
        $table->dropColumn('advisor_id');
    });
}

};

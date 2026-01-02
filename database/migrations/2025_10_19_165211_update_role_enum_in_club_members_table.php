<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


//Migration for updating role enum in club_members table (adding new roles for each high committee position)
return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::table('club_members', function (Blueprint $table) {
    $table->enum('role', [
        'leader',
        'vice_leader',
        'treasurer',
        'secretary',
        'event_coordinator',
        'multimedia',
        'sponsorship',
        'logistic',
        'public_relations',
        'membership',
    ])->nullable()->change();
});

}

public function down(): void
{
    Schema::table('club_members', function (Blueprint $table) {
        $table->enum('role', ['leader','treasurer','secretary'])->nullable()->change();
    });
}
};

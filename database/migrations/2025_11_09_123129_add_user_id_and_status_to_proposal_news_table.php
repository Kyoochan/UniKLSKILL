<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Migration to add 'user_id' and 'status' columns to 'proposal_news' table (missing in previous migrations)
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            // Add user_id if it doesn't exist
            if (!Schema::hasColumn('proposal_news', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');

                // Add foreign key constraint only if it doesn't exist
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            // Add status if it doesn't exist
            if (!Schema::hasColumn('proposal_news', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('proposal_news', function (Blueprint $table) {
            // Drop foreign key first if exists
            if (Schema::hasColumn('proposal_news', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // Drop status column if exists
            if (Schema::hasColumn('proposal_news', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};

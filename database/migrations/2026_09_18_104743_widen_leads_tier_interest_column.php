<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Longest current slug is "agentic-ai-enterprise" (22 chars).
        Schema::table('leads', function (Blueprint $table) {
            $table->string('tier_interest', 40)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->string('tier_interest', 20)->nullable()->change();
        });
    }
};

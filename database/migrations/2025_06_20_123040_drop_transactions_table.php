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
        // Drop the table directly
        Schema::dropIfExists('transactions');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optionally, recreate the table if needed
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Add other columns and constraints as needed
        });
    }
};
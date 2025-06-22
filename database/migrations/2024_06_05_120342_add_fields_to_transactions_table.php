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
        Schema::table('transactions', function (Blueprint $table) {
            // Modify existing columns to be nullable
            $table->string('Name')->nullable()->change();
            $table->decimal('amount', 8, 2)->nullable()->change();
            $table->text('remarks')->nullable()->change();

            // Check if the 'changes' column exists before modifying it
            if (Schema::hasColumn('transactions', 'changes')) {
                $table->json('changes')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Revert columns back to non-nullable
            $table->string('Name')->nullable(false)->change();
            $table->decimal('amount', 8, 2)->nullable(false)->change();
            $table->text('remarks')->nullable(false)->change();

            // Check if the 'changes' column exists before dropping it
            if (Schema::hasColumn('transactions', 'changes')) {
                $table->dropColumn('changes');
            }
        });
    }
};
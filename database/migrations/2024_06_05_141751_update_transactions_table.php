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
            $table->string('Name')->nullable(false)->change(); // Revert back if necessary
            $table->decimal('amount', 8, 2)->nullable(false)->change(); // Revert back if necessary
            $table->text('remarks')->nullable(false)->change(); // Revert back if necessary

            // Check if the 'changes' column exists before adding it
            if (!Schema::hasColumn('transactions', 'changes')) {
                $table->json('changes')->nullable();
            }

            // Check if the 'target' column exists before adding it
            if (!Schema::hasColumn('transactions', 'target')) {
                $table->decimal('target', 10, 2)->nullable()->after('changes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('Name')->nullable(false)->change(); // Revert back if necessary
            $table->decimal('amount', 8, 2)->nullable(false)->change(); // Revert back if necessary
            $table->text('remarks')->nullable(false)->change(); // Revert back if necessary

            // Drop the 'changes' column if it exists
            if (Schema::hasColumn('transactions', 'changes')) {
                $table->dropColumn('changes');
            }

            // Drop the 'target' column if it exists
            if (Schema::hasColumn('transactions', 'target')) {
                $table->dropColumn('target');
            }
        });
    }
};
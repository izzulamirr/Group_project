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
            $table->json('changes')->nullable();
            $table->decimal('target', 10, 2)->nullable()->after('changes');
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
            $table->dropColumn('changes'); // Revert back if necessary
            $table->dropColumn('target_amount');
        });
    }
};

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
            $table->string('Name')->nullable()->change(); // If Name already exists and needs to be nullable
            $table->decimal('amount', 8, 2)->nullable()->change(); // If amount already exists and needs to be nullable
            $table->text('remarks')->nullable()->change(); // If remarks already exists and needs to be nullable
            $table->json('changes')->nullable()->change(); // If changes already exists and needs to be nullable
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
        });
    }
};

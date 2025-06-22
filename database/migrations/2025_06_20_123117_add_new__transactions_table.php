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
    Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('organization_id');
    $table->unsignedBigInteger('donator_id');
    $table->decimal('amount', 10, 2);
    $table->string('remarks')->nullable();
    $table->timestamps();

    $table->foreign('organization_id')->references('id')->on('organizations')->onDelete('cascade');
    $table->foreign('donator_id')->references('id')->on('donators')->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

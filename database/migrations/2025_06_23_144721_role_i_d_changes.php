<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_roles', function (Blueprint $table) {
        // Drop auto-increment from RoleID (MySQL only supports this via raw SQL)
        DB::statement('ALTER TABLE user_roles MODIFY RoleID BIGINT UNSIGNED;');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        
    }
};

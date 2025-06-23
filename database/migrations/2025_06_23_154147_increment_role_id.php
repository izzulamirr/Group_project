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
        // Drop existing primary key if any
        DB::statement('ALTER TABLE user_roles DROP PRIMARY KEY');

        // Modify RoleID to be auto-increment and primary key
        DB::statement('ALTER TABLE user_roles MODIFY COLUMN RoleID BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         // Optionally, reverse the auto-increment (remove AUTO_INCREMENT and PRIMARY KEY)
        DB::statement('ALTER TABLE user_roles MODIFY COLUMN RoleID BIGINT UNSIGNED NOT NULL');
    }
};
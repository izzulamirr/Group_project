<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id('RoleID');
            $table->unsignedBigInteger('UserID');
            $table->string('RoleName');
            $table->string('Description')->nullable();
            $table->timestamps();

            $table->foreign('UserID')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
};

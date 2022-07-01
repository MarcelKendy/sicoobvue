<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('full_name');
            $table->string('cpf')->unique();
            $table->string('email')->unique();
            $table->string('photo')->nullable();
            $table->smallInteger('active');
            $table->smallInteger('gender');
            $table->string('password');
            $table->string('configs');
            $table->foreignId('access_id')->references('id')->on('accesses')->constrained();
            $table->text('profile_about');
            $table->foreignId('role_id')->references('id')->on('roles')->constrained();
            $table->string('agency');
            $table->string('address');
            $table->string('phone');
            $table->string('phone_corporation');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};

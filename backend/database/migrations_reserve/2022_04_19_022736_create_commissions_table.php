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
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('date_indicator');
            $table->string('date_seller')->nullable();
            $table->string('date_operator')->nullable();
            $table->string('associate_account')->nullable();
            $table->string('product');
            $table->decimal('value',15,2)->nullable();
            $table->decimal('custom_value',15,2)->nullable();
            $table->decimal('commission_percentage',4,2)->nullable();
            $table->decimal('credisg_commission',15,2)->nullable();
            $table->string('insurance_policy');
            $table->integer('consortium_group');
            $table->integer('consortium_quota');
            $table->tinyInteger('type');
            $table->string('status');
            $table->foreignId('indicator_id')->references('id')->on('users')->constrained();
            $table->foreignId('seller_id')->references('id')->on('users')->nullable()->constrained();
            $table->foreignId('operator_id')->references('id')->on('users')->nullable()->constrained();
            $table->decimal('indicator_commission',15,2)->nullable();
            $table->decimal('seller_commission',15,2)->nullable();
            $table->decimal('operator_commission',15,2)->nullable();

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
        Schema::dropIfExists('commissions');
    }
};

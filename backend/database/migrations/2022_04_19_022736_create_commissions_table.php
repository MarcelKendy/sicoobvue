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
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('date');
            $table->string('product');
            $table->decimal('value',15,2)->nullable();
            $table->decimal('custom_value',15,2)->nullable();
            $table->string('status');
            $table->string('indicator');
            $table->string('seller')->nullable();
            $table->string('operator')->nullable();
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

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
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('Name')->nullable(false);
            $table->integer('Amount')->nullable(false);
            $table->integer('Qty')->nullable(false);
            $table->unsignedBigInteger('FoodID')->nullable(false);
            $table->unsignedBigInteger('Userid')->nullable(false);
            $table->unsignedBigInteger('branch_id')->nullable(false);
            $table->integer('Order_id')->nullable(false);
            $table->boolean('status')->default(0);
            $table->timestamps();

            $table->foreign('FoodID')->references('id')->on('fooditems')->onDelete('cascade');
            $table->foreign('Userid')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
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
        Schema::create('food_price_quantity', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("FoodID")->nullable(false);
            $table->integer("Price")->nullable(false);
            $table->integer("Quantity")->nullable(false);
            $table->boolean('status')->nullable(false)->default(0);
            $table->timestamps();

            $table->foreign('FoodID')->references('id')->on('fooditems')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_price_quantity');
    }
};
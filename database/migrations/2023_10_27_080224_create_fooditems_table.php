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
        Schema::create('fooditems', function (Blueprint $table) {
            $table->id();
            $table->string("Image")->nullable(false);
            $table->string("Name")->nullable(false)->unique();
            $table->string("Description")->nullable(false);
            $table->unsignedBigInteger("CatergoryID")->nullable(false);
            $table->boolean('status')->nullable(false)->default(0);
            $table->unsignedBigInteger("branch_id")->nullable(false);
            $table->timestamps();
            
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
            $table->foreign('CatergoryID')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fooditems');
    }
};
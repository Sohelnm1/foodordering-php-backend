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
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('link')->nullable(false);
            $table->string('image')->nullable(false);
            $table->unsignedBigInteger("branch_id")->nullable(false);
            $table->integer("status")->nullable(false)->default(0);
            $table->string('slug')->nullable(false);
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
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
        Schema::create('social_media', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->string('link')->nullable(false);
            $table->unsignedBigInteger("branch_id")->nullable(false);
            $table->string('status')->default(0)->nullable(false);
            $table->timestamps();
            $table->foreign('branch_id')->references('id')->on('branch')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media');
    }
};
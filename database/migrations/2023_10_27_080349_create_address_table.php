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
        Schema::create('address', function (Blueprint $table) {
            $table->id();
            $table->string('Address1')->nullable(false);
            $table->string('Address2');
            $table->string('State')->nullable(false);
            $table->string('Country')->nullable(false);
            $table->unsignedBigInteger('User_id')->nullable(false);
            $table->boolean('status')->default(0);
            $table->foreign('User_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('address');
    }
};
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
        Schema::table('social_media', function (Blueprint $table) {
            //
            Schema::table('social_media', function (Blueprint $table) {
            $table->string('branchname')->nullable();
        });

        // Populate the 'branchname' column with data from the 'name' column in the 'branch' table
        \DB::table('social_media')
            ->join('branch', 'social_media.branch_id', '=', 'branch.id')
            ->update(['social_media.branchname' => \DB::raw('branch.name')]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('social_media', function (Blueprint $table) {
            //
             Schema::table('social_media', function (Blueprint $table) {
            $table->dropColumn('branchname');
        });
        });
    }
};
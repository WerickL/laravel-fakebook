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
        Schema::table('follows', function(Blueprint $table){
            $table->unsignedBigInteger('follower_user_id');
            $table->unsignedBigInteger('followed_user_id');
            $table->foreign('follower_user_id')->references('id')->on('users');
            $table->foreign('followed_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

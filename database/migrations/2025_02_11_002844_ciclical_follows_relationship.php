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
            $table->unique(['follower_user_id', 'followed_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follows', function (Blueprint $table) {
            $table->dropUnique('follows_follower_user_id_followed_user_id_unique');
            $table->dropForeign(['follower_user_id']);
            $table->dropForeign(['followed_user_id']);
            $table->dropColumn(['follower_user_id', 'followed_user_id']);
        });
    }
};

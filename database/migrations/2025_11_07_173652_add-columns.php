<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id');
            $table->unsignedBigInteger('post_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('comment_id')->nullable()->after('post_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
            $table->unique(['user_id', 'post_id']);
            $table->unique(['user_id', 'comment_id']);
        });

        DB::statement('ALTER TABLE `likes` ADD CONSTRAINT `like_post_or_comment_required` CHECK ((`post_id` IS NOT NULL) OR (`comment_id` IS NOT NULL))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE `likes` DROP CHECK `like_post_or_comment_required`');
        
        Schema::table('likes', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'post_id']);
            $table->dropUnique(['user_id', 'comment_id']);
            $table->dropForeign(['comment_id']);
            $table->dropForeign(['post_id']);
            $table->dropForeign(['user_id']);
            $table->dropColumn(['user_id', 'post_id', 'comment_id']);
        });
    }
};

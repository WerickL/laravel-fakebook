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
        if (! $this->uniqueIndexExists()) {
            Schema::table('follows', function (Blueprint $table) {
                $table->unique(['follower_user_id', 'followed_user_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if ($this->uniqueIndexExists()) {
            Schema::table('follows', function (Blueprint $table) {
                $table->dropUnique('follows_follower_user_id_followed_user_id_unique');
            });
        }
    }

    private function uniqueIndexExists(): bool
    {
        return DB::table('information_schema.statistics')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', 'follows')
            ->where('index_name', 'follows_follower_user_id_followed_user_id_unique')
            ->exists();
    }
};


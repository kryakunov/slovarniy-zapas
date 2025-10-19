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
        Schema::table('my_word_lists', function (Blueprint $table) {
            $table->foreignId('tg_user_id')->after('user_id')->nullable()->constrained('tg_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('my_word_lists', function (Blueprint $table) {
            $table->dropForeign(['tg_user_id']);
            $table->dropColumn('tg_user_id');
        });
    }
};

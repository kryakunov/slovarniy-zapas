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
        Schema::create('my_word_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('word_list_id')->index()->constrained('word_lists');
            $table->foreignId('user_id')->index()->constrained('users');
            $table->integer('learned')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('my_word_lists');
    }
};

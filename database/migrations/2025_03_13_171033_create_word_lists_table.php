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
        Schema::create('word_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('likes')->nullable();
            $table->integer('count')->nullable();
            $table->string('slug')->nullable();
            $table->foreignId('category_id')->constrained('categories')->nullable();
            $table->foreignId('type_id')->constrained('types')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('word_lists');
    }
};

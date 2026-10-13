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
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->foreignId('developer_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->string('title', 157);
            $table->unsignedSmallInteger('release_year');
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 3, 1);
            $table->boolean('is_multiplayer')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};

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
        Schema::create('pokemons', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('sprite')->nullable();
            $table->integer('height');
            $table->integer('weight');        
            $table->unsignedBigInteger('primary_type_id');
            $table->unsignedBigInteger('secondary_type_id')->nullable();
            $table->unsignedBigInteger('generation_id');
        
            $table->tinyInteger('evolution_stage')->nullable(); // 1, 2 o 3
            $table->string('color')->nullable();
        
            $table->timestamps();
        
            $table->foreign('primary_type_id')->references('id')->on('types');
            $table->foreign('secondary_type_id')->references('id')->on('types');
            $table->foreign('generation_id')->references('id')->on('generations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemons');
    }
};

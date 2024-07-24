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
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rarity_id');
            $table->string('name');
            $table->integer('experience')->default(0);
            $table->integer('strength')->default(1);
            //add image attribute
            $table->timestamps();

            $table->foreign('rarity_id')->references('id')->on('pet_rarities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};

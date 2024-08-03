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
        //INSERT INTO `telegraph_bots` (`id`, `token`, `name`, `created_at`, `updated_at`) VALUES (NULL, '7337805317:AAG9HVObiIY3UoVCcasitXQexK6gEw8cJq4', 'Bot #1', '2024-08-01 22:52:53', '2024-08-01 22:52:53')

        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rarity_id');
            $table->unsignedBigInteger('image_id')->default(1);
            $table->unsignedBigInteger('name_id')->default(1);
            $table->integer('experience')->default(0);
            $table->integer('strength')->default(1);
            $table->integer('hunger_index')->default(10); // by default full stomach
            $table->timestamps();
            
            $table->foreign('rarity_id')->references('id')->on('pet_rarities');
            $table->foreign('name_id')->references('id')->on('pet_names');
            $table->foreign('image_id')->references('id')->on('pet_images'); 
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

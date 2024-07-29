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
        Schema::table('pets', function (Blueprint $table) {
            $table->unsignedBigInteger('hunger_id')->after('name_id');

            $table->foreign('hunger_id')->references('id')->on('pet_hungers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            if(Schema::hasColumn('pets','hunger_id'))
                $table->dropColumn('hunger_id');
        });
    }
};

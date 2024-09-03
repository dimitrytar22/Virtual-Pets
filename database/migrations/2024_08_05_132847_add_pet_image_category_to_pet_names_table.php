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
        Schema::table('pet_names', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->default(1);

            $table->foreign('category_id')->references('id')->on('pet_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet_names', function (Blueprint $table) {
            if(Schema::hasColumn('pet_names','category_id'))
                $table->dropColumn('category_id');
        });
    }
};

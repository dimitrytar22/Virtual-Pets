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
        Schema::table('fortune_prizes', function (Blueprint $table) {
            $table->unsignedBigInteger('related_item')->nullable()->after('description');

            $table->foreign('related_item')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fortune_prizes', function (Blueprint $table) {
            if(Schema::hasColumn('fortune_prizes', 'related_item')) {
                $table->dropForeign('fortune_prizes_related_item_foreign');
                $table->dropColumn('related_item');
            }
        });
    }
};

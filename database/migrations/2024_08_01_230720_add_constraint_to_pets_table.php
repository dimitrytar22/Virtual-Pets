<?php

use Illuminate\Database\Eloquent\Scope;
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
        Schema::table('pets', function (Blueprint $table) {
            DB::statement('ALTER TABLE pets ADD CONSTRAINT chk_hunger_index CHECK (hunger_index >= 0 AND hunger_index <= 10)');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            Schema::hasColumn('hunger_index') == true ? $table->dropColumn('hunger_index') : $table;
            
        });
    }
};

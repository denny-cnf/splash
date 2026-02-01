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
        Schema::table('paper_types', function (Blueprint $table) {
            $table->integer('thickness')->after('density'); // толщина
            $table->integer('sheets')->after('thickness');  // количество листов
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('paper_types', function (Blueprint $table) {
            $table->dropColumn(['thickness', 'sheets']);
        });
    }
};

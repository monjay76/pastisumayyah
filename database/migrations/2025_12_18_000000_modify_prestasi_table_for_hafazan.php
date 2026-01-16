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
        Schema::table('prestasi', function (Blueprint $table) {
            // Add new columns for hafazan assessment
            $table->string('ayat')->nullable()->after('subjek'); // e.g., "Ayat 1", "Ayat 2"
            $table->string('penggal')->nullable()->after('ayat'); // "Penggal 1" or "Penggal 2"
            $table->string('tahapPencapaian')->nullable()->after('penggal'); // "AM", "M", or "SM"
            
            // Make existing columns nullable since they're not used for hafazan
            $table->integer('markah')->nullable()->change();
            $table->string('gred')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropColumn(['ayat', 'penggal', 'tahapPencapaian']);
        });
    }
};

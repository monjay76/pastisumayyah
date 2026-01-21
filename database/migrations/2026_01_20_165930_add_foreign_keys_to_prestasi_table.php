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
            $table->foreign('subject_id')->references('id')->on('subjek')->onDelete('set null');
            $table->foreign('murid_id')->references('MyKidID')->on('murid')->onDelete('cascade');
            $table->foreign('guru_id')->references('ID_Guru')->on('guru')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['murid_id']);
            $table->dropForeign(['guru_id']);
        });
    }
};

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
        // Update kehadiran table
        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade')->onUpdate('cascade');
        });

        // Update prestasi table
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade')->onUpdate('cascade');
        });

        // Update laporan table
        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade')->onUpdate('cascade');
        });

        // Update parent_murid table
        Schema::table('parent_murid', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to onDelete only
        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
        });

        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
        });

        Schema::table('laporan', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
        });

        Schema::table('parent_murid', function (Blueprint $table) {
            $table->dropForeign(['MyKidID']);
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
        });
    }
};

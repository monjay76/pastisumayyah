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
            // Drop existing foreign keys
            $table->dropForeign('prestasi_guru_id_foreign');
            $table->dropForeign('prestasi_murid_id_foreign');
            $table->dropForeign('prestasi_subject_id_foreign');

            // Make fields nullable if not already
            // Assuming they are already nullable

            // Re-add foreign keys
            $table->foreign('guru_id', 'prestasi_guru_id_foreign')->references('ID_Guru')->on('guru')->onDelete('set null');
            $table->foreign('murid_id', 'prestasi_murid_id_foreign')->references('MyKidID')->on('murid')->onDelete('cascade');
            $table->foreign('subject_id', 'prestasi_subject_id_foreign')->references('id')->on('subjek')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Drop foreign keys
            $table->dropForeign(['ID_Guru']);
            $table->dropForeign(['MyKidID']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['murid_id']);
            $table->dropForeign(['guru_id']);

            // Make not nullable
            $table->string('ID_Guru')->nullable(false)->change();
            $table->string('MyKidID')->nullable(false)->change();

            // Re-add foreign keys
            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('set null');
            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')->on('subjek')->onDelete('set null');
            $table->foreign('murid_id')->references('MyKidID')->on('murid')->onDelete('cascade');
            $table->foreign('guru_id')->references('ID_Guru')->on('guru')->onDelete('set null');
        });
    }
};

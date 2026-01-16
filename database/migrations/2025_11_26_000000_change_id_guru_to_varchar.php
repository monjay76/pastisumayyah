<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign keys that reference guru.ID_Guru so we can change column types
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['ID_Guru']);
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['direkodOleh']);
        });

        // Modify columns to varchar. Use raw statements to avoid requiring doctrine/dbal.
        DB::statement("ALTER TABLE `guru` MODIFY `ID_Guru` VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE `prestasi` MODIFY `ID_Guru` VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE `kehadiran` MODIFY `direkodOleh` VARCHAR(50) NULL");

        // Recreate foreign keys referencing the (now string) ID_Guru
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('cascade');
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->foreign('direkodOleh')->references('ID_Guru')->on('guru')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys to revert types
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign(['ID_Guru']);
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->dropForeign(['direkodOleh']);
        });

        // Attempt to revert column types. This is best-effort — ensure data is numeric before running down().
        DB::statement("ALTER TABLE `prestasi` MODIFY `ID_Guru` BIGINT UNSIGNED NOT NULL");
        DB::statement("ALTER TABLE `kehadiran` MODIFY `direkodOleh` BIGINT UNSIGNED NULL");
        // Attempt to make ID_Guru auto-increment again. Only works if values are numeric and unique.
        DB::statement("ALTER TABLE `guru` MODIFY `ID_Guru` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");

        // Recreate original foreign keys
        Schema::table('prestasi', function (Blueprint $table) {
            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('cascade');
        });

        Schema::table('kehadiran', function (Blueprint $table) {
            $table->foreign('direkodOleh')->references('ID_Guru')->on('guru')->onDelete('set null');
        });
    }
};

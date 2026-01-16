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
        // Drop foreign keys that reference pentadbir.ID_Admin so we can change column types
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['diciptaOleh']);
        });

        Schema::table('ibubapa', function (Blueprint $table) {
            $table->dropForeign(['diciptaOleh']);
        });

        // Modify columns to varchar. Use raw statements to avoid requiring doctrine/dbal.
        DB::statement("ALTER TABLE `pentadbir` MODIFY `ID_Admin` VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE `guru` MODIFY `diciptaOleh` VARCHAR(50) NULL");
        DB::statement("ALTER TABLE `ibubapa` MODIFY `diciptaOleh` VARCHAR(50) NULL");

        // Recreate foreign keys referencing the (now string) ID_Admin
        Schema::table('guru', function (Blueprint $table) {
            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
        });

        Schema::table('ibubapa', function (Blueprint $table) {
            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys to revert types
        Schema::table('guru', function (Blueprint $table) {
            $table->dropForeign(['diciptaOleh']);
        });

        Schema::table('ibubapa', function (Blueprint $table) {
            $table->dropForeign(['diciptaOleh']);
        });

        // Attempt to revert column types. This is best-effort — ensure data is numeric before running down().
        DB::statement("ALTER TABLE `guru` MODIFY `diciptaOleh` BIGINT UNSIGNED NULL");
        DB::statement("ALTER TABLE `ibubapa` MODIFY `diciptaOleh` BIGINT UNSIGNED NULL");
        // Attempt to make ID_Admin auto-increment again. Only works if values are numeric and unique.
        DB::statement("ALTER TABLE `pentadbir` MODIFY `ID_Admin` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT");

        // Recreate original foreign keys
        Schema::table('guru', function (Blueprint $table) {
            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
        });

        Schema::table('ibubapa', function (Blueprint $table) {
            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
        });
    }
};

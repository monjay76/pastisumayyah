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
        // Modify ID_Parent to varchar and ID_Parent in parent_murid to varchar
        DB::statement("ALTER TABLE `ibubapa` MODIFY `ID_Parent` VARCHAR(50) NOT NULL");
        DB::statement("ALTER TABLE `parent_murid` MODIFY `ID_Parent` VARCHAR(50) NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key
        Schema::table('ibubapa', function (Blueprint $table) {
            $table->dropForeign(['diciptaOleh']);
        });

        // Revert to integer (but since it's primary key, need to handle carefully)
        // For simplicity, just change back to varchar if needed, but actually for down, perhaps leave as is
        DB::statement("ALTER TABLE `ibubapa` MODIFY `ID_Parent` INT AUTO_INCREMENT PRIMARY KEY");
        DB::statement("ALTER TABLE `ibubapa` MODIFY `diciptaOleh` BIGINT UNSIGNED NULL");

        // Recreate foreign key
        Schema::table('ibubapa', function (Blueprint $table) {
            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
        });
    }
};

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
        // Check if columns exist before dropping
        $columns = Schema::getColumnListing('prestasi');
        $columnsToDrop = [];

        if (in_array('ID_Guru', $columns)) {
            $columnsToDrop[] = 'ID_Guru';
        }
        if (in_array('MyKidID', $columns)) {
            $columnsToDrop[] = 'MyKidID';
        }

        if (!empty($columnsToDrop)) {
            // Try to drop any foreign keys first
            try {
                DB::statement('ALTER TABLE prestasi DROP FOREIGN KEY prestasi_id_guru_foreign');
            } catch (\Exception $e) {
                // Ignore if not exists
            }
            try {
                DB::statement('ALTER TABLE prestasi DROP FOREIGN KEY prestasi_mykidid_foreign');
            } catch (\Exception $e) {
                // Ignore if not exists
            }

            Schema::table('prestasi', function (Blueprint $table) use ($columnsToDrop) {
                $table->dropColumn($columnsToDrop);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Recreate the old columns only if they don't exist
            if (!Schema::hasColumn('prestasi', 'ID_Guru')) {
                $table->unsignedBigInteger('ID_Guru')->nullable();
            }
            if (!Schema::hasColumn('prestasi', 'MyKidID')) {
                $table->string('MyKidID');
            }
        });
    }
};

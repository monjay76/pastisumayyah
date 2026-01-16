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
            // Add foreign key columns only if they don't exist
            if (!Schema::hasColumn('prestasi', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->nullable()->after('subjek');
            }
            if (!Schema::hasColumn('prestasi', 'murid_id')) {
                $table->string('murid_id')->nullable()->after('MyKidID');
            }
            if (!Schema::hasColumn('prestasi', 'guru_id')) {
                $table->string('guru_id')->nullable()->after('ID_Guru');
            }

            // Change penggal from string to integer
            $table->integer('penggal')->nullable()->change();

            // Add kriteria_nama field only if it doesn't exist
            if (!Schema::hasColumn('prestasi', 'kriteria_nama')) {
                $table->string('kriteria_nama')->nullable()->after('penggal');
            }

            // Modify existing tahapPencapaian to tahap_pencapaian enum
            if (Schema::hasColumn('prestasi', 'tahapPencapaian')) {
                $table->renameColumn('tahapPencapaian', 'tahap_pencapaian');
                $table->enum('tahap_pencapaian', ['AM', 'M', 'SM'])->nullable()->change();
            } elseif (!Schema::hasColumn('prestasi', 'tahap_pencapaian')) {
                $table->enum('tahap_pencapaian', ['AM', 'M', 'SM'])->nullable()->after('kriteria_nama');
            }

            // Add foreign key constraints only if columns exist
            if (Schema::hasColumn('prestasi', 'subject_id')) {
                $table->foreign('subject_id')->references('id')->on('subjek')->onDelete('set null');
            }
            if (Schema::hasColumn('prestasi', 'murid_id')) {
                $table->foreign('murid_id')->references('MyKidID')->on('murid')->onDelete('cascade');
            }
            if (Schema::hasColumn('prestasi', 'guru_id')) {
                $table->foreign('guru_id')->references('ID_Guru')->on('guru')->onDelete('set null');
            }

            // Add indexes for better performance only if columns exist
            if (Schema::hasColumn('prestasi', 'murid_id') &&
                Schema::hasColumn('prestasi', 'subject_id') &&
                Schema::hasColumn('prestasi', 'kriteria_nama')) {
                $table->index(['murid_id', 'subject_id', 'penggal', 'kriteria_nama']);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            // Drop foreign key constraints
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['murid_id']);
            $table->dropForeign(['guru_id']);

            // Drop added columns
            $table->dropColumn(['subject_id', 'murid_id', 'guru_id', 'kriteria_nama']);

            // Revert penggal back to string
            $table->string('penggal')->nullable()->change();

            // Revert tahap_pencapaian back to string
            $table->string('tahapPencapaian')->nullable()->change();

            // Drop index
            $table->dropIndex(['murid_id', 'subject_id', 'penggal', 'kriteria_nama']);
        });
    }
};

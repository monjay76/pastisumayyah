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
            $table->foreign('ID_Guru', 'prestasi_id_guru_foreign')->references('ID_Guru')->on('guru')->onDelete('set null');
            $table->foreign('MyKidID', 'prestasi_mykidid_foreign')->references('MyKidID')->on('murid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prestasi', function (Blueprint $table) {
            $table->dropForeign('prestasi_id_guru_foreign');
            $table->dropForeign('prestasi_mykidid_foreign');
        });
    }
};

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
        Schema::create('laporan', function (Blueprint $table) {
            $table->id('ID_Laporan');
            $table->string('MyKidID');
            $table->string('jenisLaporan');
            $table->string('bulan');
            $table->string('tahun');
            $table->string('prestasiKeseluruhan')->nullable();
            $table->string('prestasiKehadiran')->nullable();
            $table->date('tarikhJana');
            $table->timestamps();

            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

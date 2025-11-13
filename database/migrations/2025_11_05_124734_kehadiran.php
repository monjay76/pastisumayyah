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
        Schema::create('kehadiran', function (Blueprint $table) {
            $table->id('ID_Kehadiran');
            $table->date('tarikh');
            $table->string('status');
            $table->string('MyKidID');
            $table->unsignedBigInteger('direkodOleh')->nullable();
            $table->timestamps();

            $table->foreign('MyKidID')->references('MyKidID')->on('murid')->onDelete('cascade');
            $table->foreign('direkodOleh')->references('ID_Guru')->on('guru')->onDelete('set null');
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

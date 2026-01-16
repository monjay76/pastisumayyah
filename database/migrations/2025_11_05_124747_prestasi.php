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
        Schema::create('prestasi', function (Blueprint $table) {
            $table->id('ID_Prestasi');
            $table->unsignedBigInteger('ID_Guru')->nullable();
            $table->string('MyKidID');
            $table->string('subjek');
            $table->integer('markah');
            $table->string('gred');
            $table->date('tarikhRekod');
            $table->timestamps();

            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('set null');
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

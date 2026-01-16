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
<<<<<<< HEAD
            $table->unsignedBigInteger('ID_Guru')->nullable();
=======
            $table->unsignedBigInteger('ID_Guru');
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
            $table->string('MyKidID');
            $table->string('subjek');
            $table->integer('markah');
            $table->string('gred');
            $table->date('tarikhRekod');
            $table->timestamps();

<<<<<<< HEAD
            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('set null');
=======
            $table->foreign('ID_Guru')->references('ID_Guru')->on('guru')->onDelete('cascade');
>>>>>>> 9a34c33310aad5c5ec3c0ea159a0f1e6cd8e06fd
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

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
        Schema::create('pencapaian', function (Blueprint $table) {
            $table->id();
            $table->string('murid_id');
            $table->string('subjek');
            $table->integer('penggal');
            $table->decimal('markah_rata', 3, 2)->nullable();
            $table->string('gred', 10)->nullable();
            $table->timestamps();

            $table->foreign('murid_id')->references('MyKidID')->on('murid')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencapaian');
    }
};
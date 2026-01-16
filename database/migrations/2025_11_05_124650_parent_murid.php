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
        Schema::create('parent_murid', function (Blueprint $table) {
            $table->id('ID_Relate');
            $table->unsignedBigInteger('ID_Parent');
            $table->string('MyKidID');

            $table->foreign('ID_Parent')->references('ID_Parent')->on('ibubapa')->onDelete('cascade');
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

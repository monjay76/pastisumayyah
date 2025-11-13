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
        Schema::create('pentadbir', function (Blueprint $table) {
            $table->id('ID_Admin');
            $table->string('namaAdmin');
            $table->string('emel')->unique();
            $table->string('kataLaluan');
            $table->string('noTel');
            $table->timestamps();
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

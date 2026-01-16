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
        Schema::create('ibubapa', function (Blueprint $table) {
            $table->id('ID_Parent');
            $table->string('namaParent');
            $table->string('emel')->unique();
            $table->string('noTel');
            $table->string('kataLaluan');
            $table->unsignedBigInteger('diciptaOleh')->nullable();
            $table->text('maklumBalas')->nullable();
            $table->timestamps();

            $table->foreign('diciptaOleh')->references('ID_Admin')->on('pentadbir')->onDelete('set null');
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

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
        Schema::create('klinik', function (Blueprint $table) {
            $table->id('id_klinik');
            $table->string('nama_klinik');
            $table->text('alamat_klinik');
            $table->string('no_telp_klinik');
            $table->string('email_klinik');
            $table->string('jam_operasional_klinik');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('klinik');
    }
};

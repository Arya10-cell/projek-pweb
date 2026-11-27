<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('antrean', function (Blueprint $table) {
            $table->id('id_antrean');
            $table->foreignId('id_pendaftaran')
                ->unique()
                ->constrained('pendaftaran', 'id_pendaftaran')
                ->cascadeOnDelete();
            $table->unsignedBigInteger('nomor_antrean');
            $table->date('tanggal_antrean');
            $table->enum('status_antrean', ['menunggu', 'dipanggil', 'selesai', 'dilewati'])
                ->default('menunggu');
            $table->date('waktu_dipanggil')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antrean');
    }
};
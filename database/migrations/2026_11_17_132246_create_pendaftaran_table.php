<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran', function (Blueprint $table) {
            $table->id('id_pendaftaran');
            $table->foreignId('id_user')
                ->constrained('user', 'id_user')
                ->cascadeOnDelete();
            $table->foreignId('id_jadwal')
                ->constrained('jadwal_dokter', 'id_jadwal')
                ->cascadeOnDelete();
            $table->date('tanggal_pendaftaran');
            $table->date('tanggal_kunjungan');
            $table->text('keluhan')->nullable();
            $table->enum('status_pendaftaran', ['menunggu', 'dikonfirmasi', 'selesai', 'batal'])
                ->default('menunggu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran');
    }
};
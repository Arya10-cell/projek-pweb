<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal_dokter', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_dokter')
                ->constrained('dokter', 'id_dokter')
                ->cascadeOnDelete();
            $table->foreignId('id_poli')
                ->constrained('poli', 'id_poli')
                ->cascadeOnDelete();
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->integer('kuota_pasien')->default(20);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jadwal_dokter');
    }
};
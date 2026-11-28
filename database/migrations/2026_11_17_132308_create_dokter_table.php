<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
    Schema::create('dokter', function (Blueprint $table) {
    $table->id('id_dokter');
    $table->foreignId('id_user')->unique()->constrained('user', 'id_user')->cascadeOnDelete();
    $table->string('spesialisasi');
    $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
    $table->timestamps();
});
    }

    public function down(): void
    {
        Schema::dropIfExists('dokter');
    }
};
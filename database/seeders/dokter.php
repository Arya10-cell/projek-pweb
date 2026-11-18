<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class dokter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('dokter')->insert([
            [
                'nama_dokter' => 'Dr. Budi Santoso',
                'spesialisasi' => 'Dokter Umum',
                'no_telepon' => '081234567890',
                'status' => 'aktif',
                'id_klinik' => 1,
            ],
            [
                'nama_dokter' => 'Dr. Siti Aminah',
                'spesialisasi' => 'Dokter Gigi',
                'no_telepon' => '081234567891',
                'status' => 'aktif',
                'id_klinik' => 1,
            ],
        ]);
    }
}

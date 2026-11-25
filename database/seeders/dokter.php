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
            [
                'nama_dokter' => 'Dr. Andi Wijaya',
                'spesialisasi' => 'Dokter Anak',
                'no_telepon' => '081234567892',
                'status' => 'aktif',
                'id_klinik' => 2,
            ],
            [
                'nama_dokter' => 'Dr. Rina Pratiwi',
                'spesialisasi' => 'Dokter Kandungan',
                'no_telepon' => '081234567893',
                'status' => 'non-aktif',
                'id_klinik' => 2,
            ]
        ]);
    }
}

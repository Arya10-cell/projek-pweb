<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class poli extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('poli')->insert([
            [
                'nama_poli' => 'Poli Umum',
                'deskripsi' => 'Pelayanan kesehatan umum untuk semua pasien.',
                'id_klinik' => 1,
            ],
            [
                'nama_poli' => 'Poli Gigi',
                'deskripsi' => 'Pelayanan kesehatan gigi dan mulut.',
                'id_klinik' => 1,
            ],
            [
                'nama_poli' => 'Poli Anak',
                'deskripsi' => 'Pelayanan kesehatan khusus untuk anak-anak.',
                'id_klinik' => 1,
            ],
        ]);
    }
}

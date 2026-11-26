<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class antrean extends Seeder
{
    // Run the database seeds.

    public function run(): void
    {
        DB::table('antrean')->insert([
            [
                'id_pendaftaran' => 1,
                'nomor_antrean' => 1,
                'tanggal_antrean' => now(),
                'status_antrean' => 'menunggu',
                'waktu_dipanggil' => null,
            ],
        ]);
    }
}

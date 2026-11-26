<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class pendaftaran extends Seeder
{
    public function run(): void
    {
        DB::table('pendaftaran')->insert([
            [
                'id_user' => 1,
                'id_jadwal' => 1,
                'tanggal_pendaftaran' => now()->toDateString(),
                'tanggal_kunjungan' => now()->addDay()->toDateString(),
                'keluhan' => 'Demam dan batuk',
                'status_pendaftaran' => 'menunggu',
            ],
        ]);
    }
}

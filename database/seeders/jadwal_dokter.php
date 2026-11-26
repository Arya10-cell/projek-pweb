<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class jadwal_dokter extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_dokter')->insert([
            [
                'id_dokter' => 1,
                'id_poli' => 1,
                'hari' => 'senin',
                'jam_mulai' => '08:00:00',
                'jam_selesai' => '12:00:00',
            ],
            [
                'id_dokter' => 1,
                'id_poli' => 1,
                'hari' => 'rabu',
                'jam_mulai' => '13:00:00',
                'jam_selesai' => '17:00:00',
            ],
        ]);
    }
}

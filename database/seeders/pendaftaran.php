<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class pendaftaran extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendaftaran')->insert([
            [
                'id_user' => 1,
                'id_poli' => 1,
                'tanggal_pendaftaran' => now(),
                'status_pendaftaran' => 'pending',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class klinik extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('klinik')->insert([
            [
                'nama_klinik' => 'Klinik Sehat Selalu',
                'alamat_klinik' => 'Jl. Sehat No. 123, Jakarta',
                'no_telp_klinik' => '021-12345678',
                'email_klinik' => 'kliniksehatselalu@gmail.com',
                'jam_operasional_klinik' => '08:00 - 17:00',
            ],
        ]);
    }
}

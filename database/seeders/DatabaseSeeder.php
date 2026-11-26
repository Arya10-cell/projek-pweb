<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            klinik::class,
            user::class,
            dokter::class,
            poli::class,
            jadwal_dokter::class,
            pendaftaran::class,
            antrean::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class dokter extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'dokter@gmail.com')->first();

        $user->dokter()->updateOrCreate(
            ['id_user' => $user->id_user],
            ['spesialisasi' => 'Dokter Umum', 'status' => 'aktif']
        );
    }
}
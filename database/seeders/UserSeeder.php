<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('user')->insert([
            [
                'nama' => 'Paijo',
                'email' => 'Paijo@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081234567890',
                'alamat' => 'Jl.Jawa No. 1',
                'jenis_kelamin' => 'Laki-laki',
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dr. Budi',
                'email' => 'dokter@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081234567891',
                'alamat' => 'Jl.Jawa No. 2',
                'jenis_kelamin' => 'Laki-laki',
                'role' => 'dokter',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti',
                'email' => 'pasien@gmail.com',
                'password' => Hash::make('password'),
                'no_telepon' => '081234567892',
                'alamat' => 'Jl.Jawa No. 3',
                'jenis_kelamin' => 'Perempuan',
                'role' => 'pasien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
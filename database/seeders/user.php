<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class user extends Seeder
{
    // Run the database seeds.

    public function run(): void
    {
        DB::table('user')->insert([
            [
                'nama' => 'Paijo',
                'email' => 'Paijo@gmail.com',
                'password' => bcrypt('password'),
                'no_telepon' => '081234567890',
                'alamat' => 'Jl.Jawa No. 1',
                'jenis_kelamin' => 'Laki-laki',
                'role' => 'admin',
            ],
        ]);
    }
}

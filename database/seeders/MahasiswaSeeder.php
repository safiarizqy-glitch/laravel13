<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Models\User;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Budi Santoso',
            'username' => '2311001',
            'password' => '123456',
            'role'     => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id'  => $user->id,
            'nim'      => '2311001',
            'nama'     => 'Budi Santoso',
            'alamat'   => 'Pangkalpinang',
            'prodi_id' => Prodi::where(
                'nama_prodi',
                'D4 Teknologi Rekayasa Perangkat Lunak'
            )->first()->id,
        ]);



        $user = User::create([
            'name'     => 'Siti Aisyah',
            'username' => '2311002',
            'password' => '123456',
            'role'     => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id'  => $user->id,
            'nim'      => '2311002',
            'nama'     => 'Siti Aisyah',
            'alamat'   => 'Sungailiat',
            'prodi_id' => Prodi::where(
                'nama_prodi',
                'Bisnis Digital'
            )->first()->id,
        ]);
    }
}
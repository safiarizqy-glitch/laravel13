<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Prodi;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mahasiswa::create([
            'nim' => '2311001',
            'nama' => 'Budi Santoso',
            'alamat' => 'Pangkalpinang',
            'prodi_id' => Prodi::where(
                'nama_prodi',
                'D4 Teknologi Rekayasa Perangkat Lunak'
            )->first()->id
        ]);

        Mahasiswa::create([
            'nim' => '2311002',
            'nama' => 'Siti Aisyah',
            'alamat' => 'Sungailiat',
            'prodi_id' => Prodi::where(
                'nama_prodi',
                'Bisnis Digital'
            )->first()->id
        ]);
    }
}
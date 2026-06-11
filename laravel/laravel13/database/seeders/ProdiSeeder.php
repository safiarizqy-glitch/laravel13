<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Prodi;

class ProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Prodi::create([
            'nama_prodi' => 'D4 Teknologi Rekayasa Perangkat Lunak',
            'jurusan_id' => Jurusan::where('nama_jurusan', 'Informatika dan Bisnis')->first()->id
        ]);

        Prodi::create([
            'nama_prodi' => 'Bisnis Digital',
            'jurusan_id' => Jurusan::where('nama_jurusan', 'Informatika dan Bisnis')->first()->id
        ]);

        Prodi::create([
            'nama_prodi' => 'D4 Elektronika',
            'jurusan_id' => Jurusan::where('nama_jurusan', 'Elektro dan Industri Pertanian')->first()->id
        ]);

        Prodi::create([
            'nama_prodi' => 'D4 Teknik Mesin dan Manufaktur',
            'jurusan_id' => Jurusan::where('nama_jurusan', 'Rekayasa Mesin dan Manufaktur')->first()->id
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jurusan;


class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jurusan::create([
            'nama_jurusan' => 'Rekayasa Mesin dan Manufaktur'
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Elektro dan Industri Pertanian'
        ]);

        Jurusan::create([
            'nama_jurusan' => 'Informatika dan Bisnis'
        ]);
    }
}
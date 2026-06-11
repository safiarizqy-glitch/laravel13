<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prodi extends Model
{
    protected $fillable = [
        'jurusan_id',
        'nama_prodi'
    ];

    // banyak prodi milik 1 jurusan
    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // 1 prodi punya banyak mahasiswa
    public function mahasiswas()
    {
        return $this->hasMany(Mahasiswa::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $fillable = [
        'nama_jurusan'
    ];

    // 1 jurusan punya banyak prodi
    public function prodis()
    {
        return $this->hasMany(Prodi::class);
    }
}
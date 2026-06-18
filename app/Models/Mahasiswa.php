<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $fillable = [
        'user_id',
        'prodi_id',
        'nim',
        'nama',
        'alamat'
    ];


    // banyak mahasiswa milik 1 prodi
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
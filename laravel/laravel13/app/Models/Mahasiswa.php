<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'prodi_id',
        'nim',
        'nama',
        'alamat',
    ];
    
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }
}
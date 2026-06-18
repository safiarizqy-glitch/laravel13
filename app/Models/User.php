<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];


    protected $hidden = [
        'password',
        'remeber_token',
    ];
    

    protected function casts(): array
    {
        return [
            
            'password' => 'hashed',
        ];
    }

    public function mahasiswa(){
        return $this->hasOne(Mahasiswa::class);
    }
}
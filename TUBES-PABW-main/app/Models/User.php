<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\BuatLaporan;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'notelp',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    public function laporans()
    {
        return $this->hasMany(BuatLaporan::class, 'user_id');
    }

    public function beritaComments()
    {
        return $this->hasMany(BeritaComment::class, 'user_id');
    }

    public function beritaLikes()
    {
        return $this->hasMany(BeritaLike::class, 'user_id');
    }
}

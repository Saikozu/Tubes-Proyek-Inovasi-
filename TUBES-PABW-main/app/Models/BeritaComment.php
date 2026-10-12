<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'berita_id',
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function berita()
    {
        return $this->belongsTo(Berita::class);
    }
}

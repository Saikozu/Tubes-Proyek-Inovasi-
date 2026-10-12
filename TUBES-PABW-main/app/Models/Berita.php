<?php

namespace App\Models;

use Illuminate\Support\Facades\App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_TAKEDOWN = 'takedown';

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'status',
    ];

    public function scopePublished($query)
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function comments()
    {
        return $this->hasMany(BeritaComment::class, 'berita_id');
    }

    public function likes()
    {
        return $this->hasMany(BeritaLike::class, 'berita_id');
    }
}

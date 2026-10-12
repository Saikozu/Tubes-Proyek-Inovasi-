<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class BuatLaporan extends Model
{
    protected $table = 'buatlaporan';

    public const KATEGORI_PRIORITAS = [
        'Pencurian' => 'Sedang',
        'Perampokan' => 'Tinggi',
        'Kekerasan' => 'Tinggi',
        'Penipuan' => 'Sedang',
        'Narkotika' => 'Tinggi',
        'Penganiayaan' => 'Tinggi',
        'Vandalisme' => 'Rendah',
        'Lainnya' => 'Rendah',
    ];

    protected $fillable = [
        'user_id',
        'nama',
        'email',
        'notelp',
        'kategori',
        'prioritas',
        'status',
        'date',
        'time',
        'polres',
        'alamat',
        'foto',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

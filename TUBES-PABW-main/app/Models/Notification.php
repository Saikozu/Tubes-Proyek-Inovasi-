<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
        protected $fillable = [
        'user_id',
        'laporan_id',
        'title',
        'message',
        'is_read'
    ];

    public function laporan()
    {
        return $this->belongsTo(BuatLaporan::class, 'laporan_id');
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'cabang_id',
        'jenis_pembayaran',
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }
    public function jadwal()
    {
        return $this->hasMany(Jadwal::class);
    }
}

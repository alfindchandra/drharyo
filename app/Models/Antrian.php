<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Antrian extends Model
{
    use HasFactory;

    protected $table = 'antrian';
    protected $fillable = [
        'cabang_id',
        'pembayaran_id',
        'tanggal',
        'jadwal_dokter_id',
        'dokter_id',
        'nama_pasien',
        'nik',
        'no_wa',
        'nomor_antrian',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date'
    ];

    public function cabang()
    {
        return $this->belongsTo(Cabang::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }

    public function pembayaran()
    {
        return $this->belongsTo(Pembayaran::class);
    }

    public static function getNextNomorAntrian($cabang_id, $tanggal, $dokter_id)
    {
        $lastAntrian = self::where('cabang_id', $cabang_id)
            ->where('tanggal', $tanggal)
            ->where('dokter_id', $dokter_id)
            ->max('nomor_antrian');

        return $lastAntrian ? $lastAntrian + 1 : 1;
    }
}
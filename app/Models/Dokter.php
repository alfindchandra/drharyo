<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $fillable = [
        'nama_dokter',
        'spesialisasi',
        'telepon'
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }
}
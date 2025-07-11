<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabang extends Model
{
    use HasFactory;

    protected $table = 'cabang';
    protected $fillable = [
        'nama_cabang',
        'alamat',
        'email',
        'telepon'
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany; // Add this import

class Dokter extends Model
{
    use HasFactory;

    protected $table = 'dokter';
    protected $fillable = [
        'nama_dokter',
        'id_cabang',
    ];

    public function antrian()
    {
        return $this->hasMany(Antrian::class);
    }

    /**
     * Get the schedules for the doctor.
     */
    public function schedules(): HasMany // Define the relationship to Schedule
    {
        return $this->hasMany(Schedule::class, 'doctor_id');
    }
}
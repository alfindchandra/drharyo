<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Dokter;

class DokterSeeder extends Seeder
{
    public function run()
    {
        Dokter::create([
            'nama_dokter' => 'dr. Haryo Bagus Trenggono, Sp.M',
            'spesialisasi' => 'Spesialis Mata',
            'telepon' => '081234567890'
        ]);

        Dokter::create([
            'nama_dokter' => 'dr. R. Hasya Arianda, Sp.M',
            'spesialisasi' => 'Spesialis Mata',
            'telepon' => '081234567891'
        ]);

        Dokter::create([
            'nama_dokter' => 'Dr. Harijo Wahjudi BS., dr., Sp.M(K).',
            'spesialisasi' => 'Spesialis Penyakit Dalam',
            'telepon' => '081234567892'
        ]);

        Dokter::create([
            'nama_dokter' => 'dr. Sekar Ayu Sitoresmi, Sp.M., M.Ked.Klin',
            'spesialisasi' => 'Spesialis Kandungan',
            'telepon' => '081234567893'
        ]);
    }
}

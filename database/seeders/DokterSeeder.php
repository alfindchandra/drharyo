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
            'id_cabang' => '1',
        ]);

        Dokter::create([
            'nama_dokter' => 'dr. R. Hasya Arianda, Sp.M',
            'id_cabang' => '1',
 
        ]);

        Dokter::create([
            'nama_dokter' => 'Dr. Harijo Wahjudi BS., dr., Sp.M(K).',
            'id_cabang' => '2',

        ]);

        Dokter::create([
            'nama_dokter' => 'dr. Sekar Ayu Sitoresmi, Sp.M., M.Ked.Klin',
            'id_cabang' => '2',
        ]);
    }
}

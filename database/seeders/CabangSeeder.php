<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cabang;

class CabangSeeder extends Seeder
{
    public function run()
    {
        Cabang::create([
            'nama_cabang' => 'Bojonegoro',
            'alamat' => 'Jl. Ade Irma Suryani No.7, Sumbang, Kec. Bojonegoro, Kabupaten Bojonegoro',
            'email'=> 'drharyoklinikmata@gmail.com',
            'telepon' => '+6287794497271'
        ]);

        Cabang::create([
            'nama_cabang' => 'Surabaya',
            'alamat' => 'Jl. Rungkut Asri Utara XIII No.10, Kali Rungkut, Kec. Rungkut, Surabaya',
            'email'=> 'drharyoeyecare@gmail.com',
            'telepon' => '+6282231198000'
        ]);

       
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Pembayaran;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pembayaran::create([
            'cabang_id' => '1',
            'jenis_pembayaran' => 'Umum',
        ]);

        Pembayaran::create([
            'cabang_id' => '1',
            'jenis_pembayaran' => 'BPJS',
        ]);

        Pembayaran::create([
            'cabang_id' => '2',
            'jenis_pembayaran' => 'Umum',
        ]);
    }
}

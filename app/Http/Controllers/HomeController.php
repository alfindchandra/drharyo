<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Dokter;
use App\Models\Antrian;

class HomeController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all(); // Mengambil semua data cabang
        $dokter = Dokter::all(); // Mengambil semua data dokter

        return view('home', compact('cabang', 'dokter')); // Meneruskan data ke view
    }

    // ... metode lainnya tetap sama
    public function store(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'rencana_pembayaran' => 'required|in:Umum,BPJS,Asuransi', // Sesuaikan jika ingin hanya Umum, BPJS
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required|in:Pagi,Siang,Sore', // Sesuaikan jika ingin hanya Pagi, Malam
            'dokter_id' => 'required|exists:dokter,id',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|size:16',
            'no_wa' => 'required|string|max:15',
        ]);

        $nomorAntrian = Antrian::getNextNomorAntrian(
            $request->cabang_id,
            $request->tanggal,
            $request->dokter_id
        );

        $antrian = Antrian::create([
            'cabang_id' => $request->cabang_id,
            'rencana_pembayaran' => $request->rencana_pembayaran,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'dokter_id' => $request->dokter_id,
            'nama_pasien' => $request->nama_pasien,
            'nik' => $request->nik,
            'no_wa' => $request->no_wa,
            'nomor_antrian' => $nomorAntrian,
        ]);

        return redirect()->back()->with('success', 'Antrian berhasil dibuat dengan nomor: ' . $nomorAntrian);
    }

    public function getJamPraktek()
    {
        // Untuk contoh, mengembalikan jam praktek klinik umum
        return response()->json([
            'jam_praktek' => [
                'senin_jumat' => '08:00 - 17:00',
                'sabtu' => '08:00 - 12:00',
                'minggu' => 'Tutup'
            ]
        ]);
    }

    public function getAntrianByDokter(Request $request)
    {
        $antrian = Antrian::with(['cabang', 'dokter'])
            ->where('dokter_id', $request->dokter_id)
            ->where('tanggal', $request->tanggal)
            ->orderBy('nomor_antrian')
            ->get();

        return response()->json($antrian);
    }
}
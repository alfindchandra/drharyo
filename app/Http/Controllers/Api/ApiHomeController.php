<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Dokter;
use App\Models\Antrian;

class ApiHomeController extends Controller
{
    public function getCabang()
    {
        try {
            $cabang = Cabang::all();
            return response()->json([
                'success' => true,
                'data' => $cabang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching cabang: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDokter()
    {
        try {
            $dokter = Dokter::all();
            return response()->json([
                'success' => true,
                'data' => $dokter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching dokter: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createAntrian(Request $request)
    {
        try {
            $request->validate([
                'cabang_id' => 'required|exists:cabang,id',
                'rencana_pembayaran' => 'required|in:Umum,BPJS,Asuransi',
                'tanggal' => 'required|date|after_or_equal:today',
                'waktu' => 'required|in:Pagi,Siang,Sore',
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

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dibuat',
                'data' => $antrian->load(['cabang', 'dokter'])
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error creating antrian: ' . $e->getMessage()
            ], 500);
        }
    } 

    public function getAntrian(Request $request)
    {
        try {
            $query = Antrian::with(['cabang', 'dokter']);

            if ($request->has('cabang_id')) {
                $query->where('cabang_id', $request->cabang_id);
            }

            if ($request->has('dokter_id')) {
                $query->where('dokter_id', $request->dokter_id);
            }

            if ($request->has('tanggal')) {
                $query->where('tanggal', $request->tanggal);
            }

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $antrian = $query->orderBy('nomor_antrian')->get();

            return response()->json([
                'success' => true,
                'data' => $antrian
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching antrian: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateStatusAntrian(Request $request, $id)
    {
        try {
            $antrian = Antrian::find($id);

            if (!$antrian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian not found'
                ], 404);
            }

            $request->validate([
                'status' => 'required|in:Menunggu,Dipanggil,Selesai'
            ]);

            $antrian->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status antrian berhasil diupdate',
                'data' => $antrian->load(['cabang', 'dokter'])
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating antrian: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteAntrian($id)
    {
        try {
            $antrian = Antrian::find($id);

            if (!$antrian) {
                return response()->json([
                    'success' => false,
                    'message' => 'Antrian not found'
                ], 404);
            }

            $antrian->delete();

            return response()->json([
                'success' => true,
                'message' => 'Antrian berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting antrian: ' . $e->getMessage()
            ], 500);
        }
    }
}
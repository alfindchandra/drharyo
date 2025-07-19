<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cabang;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Antrian;
use App\Models\Pembayaran; 
class ApiHomeController extends Controller
{
    /**
     * Get all branches.
     * GET /api/v1/cabang
     */
    public function getCabang()
    {
        try {
            $cabang = Cabang::all();
            return response()->json([
                'success' => true,
                'message' => 'Data cabang berhasil diambil.',
                'data' => $cabang
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data cabang: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get doctors filtered by branch ID.
     * GET /api/v1/dokter?cabang_id={id}
     */
    public function getDokter(Request $request)
    {
        $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
        ]);

        try {
            $dokter = Dokter::where('id_cabang', $request->cabang_id)->get();
            return response()->json([
                'success' => true,
                'message' => 'Data dokter berhasil diambil.',
                'data' => $dokter
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dokter: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * Get schedules for a doctor, categorized by day and session.
     * GET /api/v1/schedule?dokter_id={id}
     */
    public function getSchedule(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
        ]);

        try {
            $schedules = Jadwal::where('doctor_id', $request->dokter_id)->get();

            $jamPraktek = [];
            $detailedSchedules = [];

            $dayMap = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];

            foreach ($schedules as $schedule) {
                $dayName = $dayMap[$schedule->day_of_week] ?? $schedule->day_of_week;
                $timeRange = substr($schedule->start_time, 0, 5) . ' - ' . substr($schedule->end_time, 0, 5) . ' (' . $schedule->tipe_sesi . ')';

                if (!isset($jamPraktek[$dayName])) {
                    $jamPraktek[$dayName] = [];
                }
                $jamPraktek[$dayName][] = $timeRange;

                // For detailed schedules used by frontend to map time categories
                if (!isset($detailedSchedules[$dayName])) {
                    $detailedSchedules[$dayName] = [];
                }
                $detailedSchedules[$dayName][] = [
                    'id' => $schedule->id, // Important for linking Antrian to specific Jadwal
                    'start_time' => $schedule->start_time,
                    'end_time' => $schedule->end_time,
                    'tipe_sesi' => $schedule->tipe_sesi,
                ];
            }

            // Format for display
            foreach ($jamPraktek as $day => $times) {
                $jamPraktek[$day] = implode(', ', $times);
            }

            return response()->json([
                'success' => true,
                'message' => 'Jadwal dokter berhasil diambil.',
                'jam_praktek' => $jamPraktek,
                'detailed_schedules' => $detailedSchedules // Send detailed data for JS logic
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil jadwal dokter: ' . $e->getMessage(),
                'jam_praktek' => [],
                'detailed_schedules' => []
            ], 500);
        }
    }

    /**
     * Get real-time queue count for a specific doctor, date, and session type.
     * GET /api/v1/antrian-count?dokter_id={id}&tanggal={date}&sesi={session_type}
     */
    public function getAntrianCount(Request $request)
    {
        $request->validate([
            'dokter_id' => 'required|exists:dokter,id',
            'tanggal' => 'required|date_format:Y-m-d',
            'sesi' => 'required|string|in:Pagi,Malam',
        ]);

        try {
            $dokterId = $request->dokter_id;
            $tanggal = $request->tanggal;
            $sesi = $request->sesi;

            // Find all schedule IDs for the given doctor, day, and session type
            $dayOfWeek = (new \DateTime($tanggal))->format('l'); // Get full day name (e.g., 'Monday')
            $dayMap = [
                'Sunday' => 'Minggu',
                'Monday' => 'Senin',
                'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu',
                'Thursday' => 'Kamis',
                'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            $laravelDayName = array_search($dayOfWeek, $dayMap) ?: $dayOfWeek;

            $jadwalIds = Jadwal::where('doctor_id', $dokterId)
                               ->where('day_of_week', $laravelDayName)
                               ->where('tipe_sesi', $sesi)
                               ->pluck('id')
                               ->toArray();

            if (empty($jadwalIds)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Tidak ada jadwal ditemukan untuk kriteria ini, sehingga tidak ada antrean.',
                    'data' => []
                ]);
            }

            $antrian = Antrian::where('dokter_id', $dokterId)
                                ->where('tanggal', $tanggal)
                                ->whereIn('jadwal_dokter_id', $jadwalIds) // Filter by specific jadwal_dokter_id
                                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Jumlah antrean berhasil diambil.',
                'data' => $antrian, // Return full data, frontend will count length
                'count' => $antrian->count() // Explicit count for convenience
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil jumlah antrean: ' . $e->getMessage(),
                'data' => []
            ], 500);
        }
    }


    /**
     * Store a new antrian entry.
     * POST /api/v1/antrian
     */
    public function storeAntrian(Request $request)
    {
        $validated = $request->validate([
            'cabang_id' => 'required|exists:cabang,id',
            'rencana_pembayaran' => 'required|string|in:Umum,BPJS',
            'tanggal' => 'required|date_format:Y-m-d',
            'waktu' => 'required|string|in:Pagi,Siang,Malam', // This maps to tipe_sesi
            'dokter_id' => 'required|exists:dokter,id',
            'nama_pasien' => 'required|string|max:255',
            'nik' => 'required|string|digits:16|unique:antrian,nik', // Added unique validation
            'no_wa' => 'nullable|string|max:20', // Assuming phone number, add specific validation if needed
        ]);

        try {
            // Determine pembayaran_id
            $pembayaran = Pembayaran::where('cabang_id', $validated['cabang_id'])
                                    ->where('jenis_pembayaran', $validated['rencana_pembayaran'])
                                    ->first();

            if (!$pembayaran) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jenis pembayaran tidak ditemukan untuk cabang ini.'
                ], 404);
            }

            // Determine jadwal_dokter_id based on doctor, date, and session type
            $dayOfWeek = (new \DateTime($validated['tanggal']))->format('l'); // e.g., 'Monday'
            $dayMap = [
                'Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa',
                'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat',
                'Saturday' => 'Sabtu',
            ];
            $laravelDayName = array_search($dayOfWeek, $dayMap) ?: $dayOfWeek;

            $jadwal = Jadwal::where('doctor_id', $validated['dokter_id'])
                            ->where('day_of_week', $laravelDayName)
                            ->where('tipe_sesi', $validated['waktu'])
                            ->first();

            if (!$jadwal) {
                return response()->json([
                    'success' => false,
                    'message' => 'Jadwal dokter tidak ditemukan untuk tanggal dan waktu yang dipilih.'
                ], 404);
            }

            // Get next nomor_antrian
            $nextNomorAntrian = Antrian::getNextNomorAntrian(
                $validated['cabang_id'],
                $validated['tanggal'],
                $validated['dokter_id']
            );

            $antrian = Antrian::create([
                'cabang_id' => $validated['cabang_id'],
                'pembayaran_id' => $pembayaran->id,
                'tanggal' => $validated['tanggal'],
                'jadwal_dokter_id' => $jadwal->id,
                'dokter_id' => $validated['dokter_id'],
                'nama_pasien' => $validated['nama_pasien'],
                'nik' => $validated['nik'],
                'no_wa' => $validated['no_wa'],
                'nomor_antrian' => $nextNomorAntrian,
                'status' => 'pending' // Default status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Antrean berhasil dibuat!',
                'data' => [
                    'id' => $antrian->id,
                    'nomor_antrian' => $antrian->nomor_antrian,
                    'sesi' => $validated['waktu'], // Pass session back for notification
                    // Add other relevant data you want to show in the notification
                ]
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan antrean: ' . $e->getMessage()
            ], 500);
        }
    }
}
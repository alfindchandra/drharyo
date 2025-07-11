<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Schedule; 

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schedule::insert([
            // Jadwal untuk doctor_id = 1
            [
                'doctor_id' => 1,
                'day_of_week' => 'Senin',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Senin',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Selasa',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Selasa',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Rabu',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Rabu',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Kamis',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Kamis',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Jumat',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
            [
                'doctor_id' => 1,
                'day_of_week' => 'Jumat',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],

            // Jadwal untuk doctor_id = 2
            [
                'doctor_id' => 2,
                'day_of_week' => 'Senin',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 2,
                'day_of_week' => 'Selasa',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 2,
                'day_of_week' => 'Rabu',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 2,
                'day_of_week' => 'Kamis',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],
            [
                'doctor_id' => 2,
                'day_of_week' => 'Jumat',
                'start_time' => '17:00:00',
                'end_time' => '21:00:00'
            ],

            // Jadwal untuk doctor_id = 3
            [
                'doctor_id' => 3,
                'day_of_week' => 'Senin',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 3,
                'day_of_week' => 'Selasa',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 3,
                'day_of_week' => 'Rabu',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 3,
                'day_of_week' => 'Kamis',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 3,
                'day_of_week' => 'Jumat',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 3,
                'day_of_week' => 'Sabtu',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],

            // Jadwal untuk doctor_id = 4
            [
                'doctor_id' => 4,
                'day_of_week' => 'Senin',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 4,
                'day_of_week' => 'Selasa',
                'start_time' => '16:00:00',
                'end_time' => '20:00:00'
            ],
            [
                'doctor_id' => 4,
                'day_of_week' => 'Sabtu',
                'start_time' => '08:00:00',
                'end_time' => '12:00:00'
            ],
        ]);
    }
}

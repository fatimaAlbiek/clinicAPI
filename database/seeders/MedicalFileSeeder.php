<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MedicalFileSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('medical_files')->insert([

            [
                'patient_id' => 1,
                'requested_by' => 1,
                'performed_by' => 4,
                'file_type' => 'Lab',
                'file_url' => 'https://res.cloudinary.com/cm5u4m60/image/upload/v1788788280/CamScanner_09-07-2026_16.10_1.pdf',
                'result' => 'Normal blood test results.',
                'status' => 'done',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 2,
                'requested_by' => 2,
                'performed_by' => null,
                'file_type' => 'Radiology',
                'file_url' => null,
                'result' => null,
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'patient_id' => 3,
                'requested_by' => 2,
                'performed_by' => 3,
                'file_type' => 'Radiology',
                'file_url' => 'https://res.cloudinary.com/cm5u4m60/image/upload/v1788785700/images.jpg',
                'result' => 'No abnormal findings detected.',
                'status' => 'done',
                'created_at' => now(),
                'updated_at' => now(),
            ],



        ]);
    }
}

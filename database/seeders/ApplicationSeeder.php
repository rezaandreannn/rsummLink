<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $applications = [
            [
                'name' => 'satu sehat',
                'image' => 'null',
                'prefix' => 'satu-sehat',
                'description' => 'Satu Sehat adalah layanan kesehatan terpadu yang menghubungkan data dari Rumah Sakit Muhammadiyah metro ke dalam platform yang praktis.'
            ],
            [
                'name' => 'v claim',
                'image' => 'null',
                'prefix' => 'v-claim',
                'description' => 'V-Claim BPJS adalah sebuah sistem yang memungkinkan peserta BPJS Kesehatan untuk mengajukan klaim atau pembayaran atas layanan kesehatan yang telah diterima secara digital.',
                'status' => 'maintenance'
            ],
            [
                'name' => 'e-claim bpjs',
                'image' => 'null',
                'prefix' => 'e-claimbpjs',
                'description' => 'E-Claim BPJS adalah pengajuan biaya perawatan pasien peserta BPJS oleh pihak rumah sakit kepada pihak BPJS Kesehatan, dilakukan secara kolektif dan ditagihkan kepada pihak BPJS Kesehatan.',
                'status' => 'inactive'
            ],
        ];

        foreach ($applications as $application) {
            Application::updateOrCreate(
                ['prefix' => $application['prefix']],
                $application
            );
        }
    }
}

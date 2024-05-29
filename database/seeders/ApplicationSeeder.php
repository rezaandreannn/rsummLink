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
                'prefix' => 'satusehat',
                'description' => 'Satu Sehat adalah layanan kesehatan terpadu yang menghubungkan data dari Rumah Sakit Muhammadiyah metro ke dalam platform yang praktis.'
            ],
            [
                'name' => 'v-claim bpjs',
                'image' => 'null',
                'prefix' => 'v-claimbpjs',
                'description' => 'V-Claim BPJS adalah sebuah sistem yang memungkinkan peserta BPJS Kesehatan untuk mengajukan klaim atau pembayaran atas layanan kesehatan yang telah diterima secara digital.'
            ],
        ];

        foreach ($applications as $application) {
            Application::updateOrCreate(
                ['prefix' => $application['prefix']], // Check for existing record by prefix
                $application // Insert or update with this data
            );
        }
    }
}
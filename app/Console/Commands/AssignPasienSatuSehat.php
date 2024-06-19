<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SatuSehat\Pasien;
use Illuminate\Support\Facades\Log;
use App\Models\Simrs\RegisterPasien;
use Satusehat\Integration\OAuth2Client;

class AssignPasienSatuSehat extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:pasien';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $batchSize = 100; // Jumlah data yang akan diambil dalam satu batch
            $latestNoMR = Pasien::latest('no_mr')->value('no_mr');

            if (!$latestNoMR) {
                $latestNoMR = '000000';
            }

            $totalPasien = RegisterPasien::where('No_MR', '>=', $latestNoMR)->count();

            for ($i = 0; $i < $totalPasien; $i += $batchSize) {
                $patients = RegisterPasien::where('No_MR', '>=', $latestNoMR)
                    ->skip($i)
                    ->take($batchSize)
                    ->get();

                foreach ($patients as $patient) {
                    if (!empty($patient->HP2)) {
                        $client = new OAuth2Client;
                        [$statusCode, $response] = $client->get_by_nik('Patient', $patient->HP2);

                        if ($statusCode == 200) {
                            if (!empty($response->entry)) {
                                $id_pasien = isset($response->entry[0]->resource->id) ? $response->entry[0]->resource->id : '';
                                $nama_pasien = isset($response->entry[0]->resource->name[0]->text) ? $response->entry[0]->resource->name[0]->text : '';

                                // Simpan data ke dalam tabel sehat_pasien
                                $existingPatient = Pasien::where('no_mr', $patient->No_MR)->first();

                                if (!$existingPatient) {
                                    // Jika data belum ada, masukkan data baru
                                    Pasien::create([
                                        'no_mr' => $patient->No_MR,
                                        'nik' => $patient->HP2,
                                        'id_pasien' => $id_pasien,
                                        'nama_pasien' => $nama_pasien
                                    ]);
                                    $this->info('Data Assign: ' . $patient->HP2);
                                } else {
                                    $this->info('Data dengan no_mr ' . $patient->No_MR . ' sudah ada, tidak dimasukkan lagi.');
                                }
                            }
                        } else {
                            // Log jika ada kesalahan dalam mendapatkan data dari API
                            Log::error('Gagal mendapatkan data dari API untuk HP2: ' . $patient->HP2);
                        }
                    } else {
                        $existingPatient = Pasien::where('no_mr', $patient->No_MR)->first();

                        if (!$existingPatient) {
                            // Jika data belum ada, masukkan data baru
                            Pasien::create([
                                'no_mr' => $patient->No_MR,
                                'nik' => $patient->HP2 ?? '',
                                'id_pasien' => '',
                                'nama_pasien' => ''
                            ]);
                            $this->info('NIK Pasien dengan NO MR ' . $patient->No_MR . ' Kosong');
                        } else {
                            $this->info('Data dengan no_mr ' . $patient->No_MR . ' sudah ada, tidak dimasukkan lagi.');
                        }
                    }
                }

                $this->info('Batch processed: ' . ($i + 1) . '-' . ($i + $batchSize));
            }

            $this->info('Insertion process completed.');
        } catch (\Exception $e) {
            // Tangkap dan log error yang terjadi
            Log::error('Terjadi error saat menjalankan insert:pasien: ' . $e->getMessage());
            $this->error('Terjadi error saat menjalankan insert:pasien: ' . $e->getMessage());
        }
    }
}

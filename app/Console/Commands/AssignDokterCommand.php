<?php

namespace App\Console\Commands;

use App\Models\SatuSehat\Practitioner;
use App\Models\Simrs\Dokter;
use Illuminate\Console\Command;
use Satusehat\Integration\OAuth2Client;

class AssignDokterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dokter:gabungkan-kode-satusehat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Menggabungkan Kode Dokter RS dengan Kode Dokter Satusehat';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $dokterRs = Dokter::filteredDokters()->get();

        foreach ($dokterRs as $dokRs) {
            if (!empty($dokRs->No_KTP)) {
                $client = new OAuth2Client;
                [$statusCode, $response] = $client->get_by_nik('Practitioner', $dokRs->No_KTP);

                if ($statusCode == 200) {
                    $id = isset($response->entry[0]->resource->id) ? $response->entry[0]->resource->id : '';
                    $nama = isset($response->entry[0]->resource->name[0]->text) ? $response->entry[0]->resource->name[0]->text : '';

                    $practitionerExisting = Practitioner::where('kode_rs', $dokRs->Kode_Dokter)->first();

                    if (!$practitionerExisting) {
                        Practitioner::create([
                            'kode_rs' => $dokRs->Kode_Dokter,
                            'id_dokter' => $id,
                            'nama_dokter' => $nama
                        ]);

                        $this->info('Data Berhasil di masukan : ' . $dokRs->Nama_Dokter);
                    } else {
                        $this->info('Data Gagal, Kode Dokter ini ' . $dokRs->Kode_Dokter . ' sudah ada');
                    }
                }
            }
        }
    }
}

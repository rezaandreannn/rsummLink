<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\SatuSehat\Location;
use Illuminate\Support\Facades\DB;
use App\Models\SatuSehat\Practitioner;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Encounter;
use App\Models\SatuSehat\Encounter\Mapping;
use App\Models\SatuSehat\TransactionLog;
use App\Models\SatuSehat\Encounter\Encounter as LocalEncounter;

class SendEncounterCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:encounter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'mengirim data encounter berdasarkan pasien yang telah datang';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // ambil data dokter yg sudah di mapping 
        $dokter = Mapping::with('practitioner')->get();
        $kode_dokters = $dokter->map(function ($mapping) {
            return $mapping->practitioner->kode_rs;
        })->toArray();


        // dd($kode_dokters);
        $databasePKU = env('DB_DATABASE_EMR');

        $antreans = DB::connection('db_rsumm')->table('DB_RSMM.dbo.ANTRIAN as a')
            ->leftJoin('DB_RSMM.dbo.REGISTER_PASIEN as rp', 'a.No_MR', '=', 'rp.No_MR')
            ->leftJoin('DB_RSMM.dbo.PENDAFTARAN as p', 'p.No_MR', '=', 'a.No_MR')
            ->leftJoin(DB::raw($databasePKU . '.dbo.TAC_RJ_STATUS as trs'), 'trs.FS_KD_REG', '=', 'p.No_Reg')
            ->select([
                // 'a.Nomor as no_antrian',
                'p.No_Reg as no_reg',
                'a.No_MR as no_mr',
                'p.Kode_Dokter as kode_dokter',
                'rp.Nama_Pasien as nama_pasien',
                'rp.HP2 as nik'
            ])
            ->where('a.Tanggal', '2023-05-12')
            ->where('p.Tanggal', '2023-05-12')
            ->where('trs.FS_STATUS', '!=', 0)
            ->where('p.Kode_Dokter', '!=', '100')
            ->whereIn('p.Kode_Dokter', $kode_dokters)
            ->whereNotNull('rp.HP2')
            ->where('rp.HP2', '!=', '')
            ->orderBy('p.No_Reg')
            ->get();

        // dd($antreans);

        foreach ($antreans as $antrean) {
            $client = new OAuth2Client;
            // Patient
            [$statusCode, $responsePatient] = $client->get_by_nik('Patient', $antrean->nik);
            if ($responsePatient->total > 0) {
                $patientId = $responsePatient->entry[0]->resource->id;
                $patientName = $responsePatient->entry[0]->resource->name[0]->text;
            } else {
                $patientId = '';
                $patientName = '';
            }
            // cari data dokter
            $dokterActives = Practitioner::where('kode_rs', $antrean->kode_dokter)->first();
            if ($dokterActives) {
                $id_practitioner = $dokterActives->id_dokter;
                $nameDokter = $dokterActives->nama_dokter;
            } else {
                $id_practitioner = '';
                $nameDokter = '';
            }
            // cari data lokasi
            // ambil location id berdasarkan dokter
            $locMapping = Mapping::where('dokter_id', $id_practitioner)->first();
            if ($locMapping) {
                $location = Location::where('location_id', $locMapping->location_id)->first();
                $locationId = $location->location_id;
                $locationName = $location->name;
            } else {
                $locationId = '';
                $locationName = '';
            }

            // Set data encounter
            $encounter = new Encounter;

            $now = Carbon::now('Asia/Jakarta');

            $encounter->addRegistrationId($antrean->no_reg);
            $encounter->setArrived($now->toAtomString());
            // $encounter->setInProgress($now->addMinutes(10)->toAtomString(), $now->addMinutes(35)->toAtomString());
            // $encounter->setFinished($now->addMinutes(45)->toAtomString());
            $encounter->setConsultationMethod('RAJAL'); // contoh metode konsultasi
            $encounter->setSubject($patientId, $patientName);
            $encounter->addParticipant($id_practitioner, $nameDokter);
            $encounter->addLocation($locationId, $locationName);
            // $encounter->addDiagnosis('condition_id', 'ICD10_code'); // contoh ID condition dan kode ICD10

            $body = $encounter->json();

            [$statusCode, $response] = $client->ss_post('Encounter', $body);

            if ($statusCode == 200) {
                $this->info('Data berhasil dikirim');
                // simpan ke database encounter
                $parts = explode('/', $$response->subject->reference);
                $parts1 = explode('/', $$response->participant->reference);
                $parts2 = explode('/', $$response->location[0]->location->reference);

                // Ambil bagian setelah karakter '/' (yaitu indeks ke-1)
                $patientId = $parts[1];
                $participantId = $parts1[1];
                $locationtId = $parts2[1];

                LocalEncounter::create([
                    'encounter_id' => $response->id,
                    'kode_register' => $response->identifier[0]->value,
                    'patient_id' => $patientId,
                    'practitioner_id' => $participantId,
                    'location_id' => $locationId,
                    'created_by' => 'cron job'
                ]);

                TransactionLog::create([
                    'registration_id' => $antrean->no_reg,
                    'status' => 'success',
                    'message' => 'data berhasil dikirim',
                    'resource' => 'Encounter'
                ]);
            } else {
                $this->info('Data gagal dikirim');
                TransactionLog::create([
                    'registration_id' => $antrean->no_reg,
                    'status' => 'failed',
                    'message' => json_encode($response),
                    'resource' => 'Encounter'
                ]);
            }
            dd($response);

            // $data = [
            //     'patientId' => $patientId,
            //     'patientName' => $patientName,
            //     'practitionerId ' => $id_practitioner,
            //     'practitionerName' => $nameDokter,
            //     'locationId' => $locationId,
            //     'locationName' => $locationName
            // ];

            // dd($data);

            // if ($data['patientId'] != '') {
            //     $this->info('Data Berhasil di masukan : ');
            // } else {
            //     $this->info('Data gagal di masukan : ');
            // }
        }
    }
}

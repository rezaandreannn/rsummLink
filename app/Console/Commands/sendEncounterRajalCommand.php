<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\SatuSehat\Location;
use Illuminate\Support\Facades\DB;
use App\Models\SatuSehat\Practitioner;
use Satusehat\Integration\OAuth2Client;
use App\Models\SatuSehat\TransactionLog;
use Satusehat\Integration\FHIR\Encounter;
use App\Models\SatuSehat\Encounter\Mapping;
use App\Models\SatuSehat\Encounter\Encounter as LocalEncounter;

class sendEncounterRajalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encounter:rajal';

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
        // Ambil data dokter yang sudah di-mapping
        $dokter = Mapping::with('practitioner')
            ->where('cara_masuk', 1)
            ->get();
        $kode_dokters = $dokter->map(function ($mapping) {
            return $mapping->practitioner->kode_rs;
        })->toArray();

        // Database EMR
        $databasePKU = env('DB_DATABASE_EMR');

        $existKodeReg = LocalEncounter::pluck('kode_register');

        $tanggal = '2023-05-16';

        // Ambil data antrean dari database rsumm
        $antreans = DB::connection('db_rsumm')->table('DB_RSMM.dbo.ANTRIAN as a')
            ->leftJoin('DB_RSMM.dbo.REGISTER_PASIEN as rp', 'a.No_MR', '=', 'rp.No_MR')
            ->leftJoin('DB_RSMM.dbo.PENDAFTARAN as p', 'p.No_MR', '=', 'a.No_MR')
            ->leftJoin(DB::raw($databasePKU . '.dbo.TAC_RJ_STATUS as trs'), 'trs.FS_KD_REG', '=', 'p.No_Reg')
            ->select([
                'p.No_Reg as no_reg',
                'a.No_MR as no_mr',
                'p.Kode_Dokter as kode_dokter',
                'rp.Nama_Pasien as nama_pasien',
                'rp.HP2 as nik',
                DB::raw("CONVERT(DATETIME, CONCAT(CONVERT(VARCHAR, a.Tanggal, 23), ' ', CONVERT(VARCHAR, a.Jam, 8)), 120) as created_at")
            ])
            ->where('a.Tanggal', $tanggal)
            ->where('p.Tanggal', $tanggal)
            ->where('trs.FS_STATUS', '!=', 0)
            ->where('p.Kode_Dokter', '!=', '100')
            ->whereIn('p.Kode_Dokter', $kode_dokters)
            ->whereNotNull('rp.HP2')
            ->where('rp.HP2', '!=', '')
            ->whereNotIn('p.No_Reg', $existKodeReg)
            ->orderBy('p.No_Reg')
            ->get();

        // dd($antreans);

        foreach ($antreans as $antrean) {
            // Ambil data pasien berdasarkan NIK
            $client = new OAuth2Client;
            [$statusCode, $responsePatient] = $client->get_by_nik('Patient', $antrean->nik);


            if ($statusCode == 200 && $responsePatient->total > 0) {
                $patientId = $responsePatient->entry[0]->resource->id;
                $patientName = $responsePatient->entry[0]->resource->name[0]->text;
            } else {
                $patientId = '';
                $patientName = '';
            }

            // Ambil data dokter berdasarkan kode dokter aktif
            $dokterActives = Practitioner::where('kode_rs', $antrean->kode_dokter)->first();

            if ($dokterActives) {
                $id_practitioner = $dokterActives->id_dokter;
                $nameDokter = $dokterActives->nama_dokter;
            } else {
                $id_practitioner = '';
                $nameDokter = '';
            }

            // Ambil data lokasi dari mapping
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

            $created = $this->add7HoursFromWib($antrean->created_at);

            $encounter->addRegistrationId($antrean->no_reg);
            $encounter->setArrived($created);
            $encounter->setConsultationMethod('RAJAL');
            $encounter->setSubject($patientId, $patientName);
            $encounter->addParticipant($id_practitioner, $nameDokter);
            $encounter->addLocation($locationId, $locationName);

            // Kirim data ke API Satu Sehat
            [$statusCode, $response] = $client->ss_post('Encounter', $encounter->json());

            if ($statusCode == 201) {
                $this->info('Data berhasil dikirim');

                // Ambil bagian setelah karakter '/'
                $patientId = $this->extractIdFromReference($response->subject->reference);
                $practitionerId = $this->extractIdFromReference($response->participant[0]->individual->reference);
                $locationId = $this->extractIdFromReference($response->location[0]->location->reference);

                $metodeKonsultasi = $response->class->code;

                // Simpan ke database local_encounters
                $this->saveLocalEncounter($response, $patientId, $practitionerId, $locationId, $metodeKonsultasi, $created);

                // Log transaksi berhasil
                $this->logTransaction($antrean->no_reg, $statusCode, $response, 'Encounter');
            } else {
                $this->info('Data gagal dikirim');

                // Log transaksi gagal
                $this->logTransaction($antrean->no_reg, $statusCode, $response, 'Encounter');
            }
        }
    }

    /**
     * Ekstrak ID dari reference
     *
     * @param string $reference
     * @return string
     */
    private function extractIdFromReference($reference)
    {
        $parts = explode('/', $reference);
        return $parts[1];
    }

    /**
     * Simpan encounter lokal ke database
     *
     * @param object $response
     * @param string $patientId
     * @param string $practitionerId
     * @param string $locationId
     * @param string $$metodeKonsultasi
     * @return void
     */
    private function saveLocalEncounter($response, $patientId, $practitionerId, $locationId, $metodeKonsultasi = NULL, $created_at = NULL)
    {
        LocalEncounter::create([
            'encounter_id' => $response->id,
            'kode_register' => $response->identifier[0]->value,
            'patient_id' => $patientId,
            'practitioner_id' => $practitionerId,
            'location_id' => $locationId,
            'created_by' => 'cron job',
            'created_at' => $created_at,
            'metode_konsultasi' => $metodeKonsultasi ?? NULL
        ]);
    }

    /**
     * Log transaksi
     *
     * @param string $registrationId
     * @param int $statusCode
     * @param object $response
     * @param string $resource
     * @return void
     */
    private function logTransaction($registrationId, $statusCode, $response, $resource)
    {
        TransactionLog::create([
            'registration_id' => $registrationId,
            'status' => $statusCode,
            'message' => json_encode($response),
            'resource' => $resource
        ]);
    }

    public function add7HoursFromWib($createdAt)
    {
        $datetime = new DateTime($createdAt);
        $datetime->modify('+7 hours');
        $atomTimestamp = $datetime->format(DateTime::ATOM);
        return $atomTimestamp;
    }
}

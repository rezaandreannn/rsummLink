<?php

namespace App\Console\Commands;

use DateTime;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\OAuth2Client;
use App\Models\SatuSehat\TransactionLog;
use Satusehat\Integration\FHIR\Observation;
use App\Models\SatuSehat\Observation as LocalObservation;
use App\Models\SatuSehat\Encounter\Encounter as LocalEncounter;

class SendObservationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'observation:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Observation TTV to Satu Sehat';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // definisikan tanggal
        $tanggal = '2023-05-16';

        // cari encounter tgl tersebut
        $localEncounter = LocalEncounter::whereDate('created_at', $tanggal)
            ->pluck('kode_register')
            ->toArray();

        // get data vital sign berdasarkan kode register
        $localObservations = DB::connection('emr')->table('PKU.dbo.TAC_RJ_VITAL_SIGN as trvs')
            ->whereIn('trvs.FS_KD_REG', $localEncounter)
            ->get();

        if (!$localObservations->isEmpty()) {
            // Hilangkan tanda '-' pada nilai-nilai
            $localObservations = $localObservations->map(function ($observation) {
                $fields = ['FS_NADI', 'FS_R', 'FS_TD', 'FS_TB', 'FS_BB', 'FS_SUHU'];
                foreach ($fields as $field) {
                    if (isset($observation->$field) && strpos($observation->$field, '-') === 0) {
                        $observation->$field = ltrim($observation->$field, '-');
                    }
                }

                // Gabungkan tanggal dan waktu menjadi created_at
                if (isset($observation->mdd) && isset($observation->FS_JAM_TRS)) {
                    $datetime = "{$observation->mdd} {$observation->FS_JAM_TRS}";
                    $observation->created_at = Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->format('Y-m-d H:i:s');
                } else {
                    $observation->created_at = null;
                }
                return $observation;
            });



            foreach ($localObservations as $localObservation) {
                if (!empty($localObservation->FS_NADI)) {
                    // cari encounter id
                    $encounter = LocalEncounter::where('kode_register', $localObservation->FS_KD_REG)
                        ->first();
                    // data berdasarkan encounter id
                    $client = new OAuth2Client;
                    [$statusById, $responById] = $client->get_by_id('Encounter', $encounter->encounter_id ?? '');

                    if ($statusById == 200) {
                        $encounterId = $responById->id;
                        $patientName = $responById->subject->display;

                        // ambil reference subject dan pisah ambil id nya saja
                        $subjectReference =  $responById->subject->reference;
                        $participantName = $responById->participant[0]->individual->display;

                        $participantId = explode('/', $responById->participant[0]->individual->reference)[1];

                        // Mengextract ID dari reference
                        $subjectReferenceId = explode('/', $subjectReference)[1];

                        $patientId = $subjectReferenceId;

                        $observation = new Observation();
                        $observation->setStatus('final');
                        $observation->addCategory('vital-signs');
                        $observation->addCode('8867-4');
                        $observation->setSubject($patientId, $patientName);
                        $observation->setPerformer($participantId, $participantName);
                        $observation->setEncounter($encounterId);
                        $observation->setValueQuantity($localObservation->FS_NADI);
                        // Kirim data ke API Satu Sehat

                        [$statusCode, $response] = $client->ss_post('Observation', $observation->json());


                        if ($statusCode == 201) {
                            $this->info('Observation successfully sent to Satu Sehat.');

                            $code = $response->code->coding[0]->code;

                            // save local db
                            $this->saveLocalObservation($response->id, $localObservation->FS_KD_REG, $code, $participantId, $localObservation->created_at);

                            // Log transaksi berhasil
                            $this->logTransaction($localObservation->FS_KD_REG, $statusCode, $response, 'Observation');
                        } else {
                            $this->error('Failed to send observation to Satu Sehat. Status code: ' . $statusCode);
                            $this->logTransaction($localObservation->FS_KD_REG, $statusCode, $response, 'Observation');
                        }
                    }
                }
            }
        } else {
            $this->error('Failed to send observation to Satu Sehat. Status code');
        }
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
            'resource' => $resource,
            'created_at' => now()
        ]);
    }

    /**
     * Simpan encounter lokal ke database
     *
     * @param object $observationId
     * @param string $kodeRegistrasi
     * @param string $code
     * @param string $participantId
     * @return void
     */
    private function saveLocalObservation($observationId, $kodeRegistrasi, $code, $participantId, $created_at = NULL)
    {
        LocalObservation::create([
            'observation_id' => $observationId,
            'kode_register' => $kodeRegistrasi,
            'code' => $code,
            'participant_id' => $participantId,
            'created_by' => 'cron job',
            'created_at' => $created_at,
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

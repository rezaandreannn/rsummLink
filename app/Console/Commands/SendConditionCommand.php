<?php

namespace App\Console\Commands;

use DateTime;
use Illuminate\Console\Command;
use App\Models\SatuSehat\Pasien;
use Satusehat\Integration\FHIR\Patient;
use Satusehat\Integration\OAuth2Client;
use App\Models\SatuSehat\TransactionLog;
use Satusehat\Integration\FHIR\Condition;
use App\Models\SatuSehat\Encounter\Encounter;
use App\Models\SatuSehat\Condition as LocalCondition;

class SendConditionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'condition:send';

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
        // get condition status 0
        $conditionRegisterIn =  LocalCondition::where('status', 0)
            ->get();

        // dd($conditionRegisterIn);

        foreach ($conditionRegisterIn as $Localcondition) {
            // cari encounter id
            $encounter = Encounter::where('kode_register', $Localcondition->kode_register)
                ->first();
            // data berdasarkan encounter id
            $client = new OAuth2Client;
            [$statusById, $responById] = $client->get_by_id('Encounter', $encounter->encounter_id ?? '');

            if ($statusById == 200) {
                $encounterId = $responById->id;
                $patientName = $responById->subject->display;

                // ambil reference subject dan pisah ambil id nya saja
                $subjectReference =  $responById->subject->reference;

                // Mengextract ID dari reference
                $subjectReferenceId = explode('/', $subjectReference)[1];

                $patientId = $subjectReferenceId;

                $created = $this->add7HoursFromWib($Localcondition->created_at);

                $condition = new Condition;
                $condition->addClinicalStatus('active'); // active, inactive, resolved. Default bila tidak dideklarasi = active
                $condition->addCategory('Diagnosis'); // Diagnosis, Keluhan. Default : Diagnosis
                $condition->addCode($Localcondition->kode_diagnosa); // Kode ICD10
                $condition->setSubject($patientId, $patientName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
                $condition->setEncounter($encounterId); // ID SATUSEHAT Encounter
                $condition->setOnsetDateTime($created); // timestamp onset. Timestamp sekarang
                // $condition->setRecordedDate($created); // timestamp recorded. Timestamp sekarang
                $condition->json();

                // Kirim data ke API Satu Sehat
                [$statusCode, $response] = $client->ss_post('Condition', $condition->json());


                if ($statusCode == 201) {
                    $this->info('Data berhasil dikirim');

                    // Simpan ke database local_condition
                    $this->updateLocalCondition($Localcondition->kode_register, $response->id);

                    // Log transaksi berhasil
                    $this->logTransaction($Localcondition->kode_register, $statusCode, $response, 'Condition');
                } else {
                    $this->info('Data gagal dikirim');

                    // Log transaksi gagal
                    $this->logTransaction($Localcondition->kode_register, $statusCode, $response, 'Condition');
                }
            } else {
                $this->info('Data gagal dikirim');

                // Log transaksi gagal
                $this->logTransaction($Localcondition->kode_register, $statusById, $responById, 'Condition');
            }
        }
    }

    /**
     * update condition lokal ke database
     *
     * @param object $kodeRegister
     * @param string $conditionId
     * @return void
     */
    private function updateLocalCondition($kodeRegister, $conditionId)
    {
        $localcondition =  LocalCondition::where('kode_register', $kodeRegister)
            ->first();

        $localcondition->update([
            'condition_id' => $conditionId,
            'status' => 1,
            'created_by' => 'cron job',
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
            'resource' => $resource,
            'created_at' => now()
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

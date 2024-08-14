<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\SatuSehat\Condition;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Encounter;
use App\Models\SatuSehat\Encounter\Encounter as LocalEncounter;

class UpdateEcounterPulangCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:encounter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update tanggal pulang pasien';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $tanggalAwal = Carbon::today()->subDays(2)->format('Y-m-d');
        $tanggalAkhir = Carbon::today()->format('Y-m-d');

        // cari data register yg ada di condition dby tanggal
        $conditions = Condition::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->where('status', 1)
            ->get();


        foreach ($conditions as $condition) {
            $encounter = LocalEncounter::where('kode_register', $condition->kode_register)
                ->where('status', null)
                ->first();


            if (!empty($encounter)) {
                // jalankan update
                // 1. ambil diagnosa 
                $conditionId = $condition->condition_id;
                $kodeDoagnosa = $condition->kode_diagnosa;
                // 2. ambil encounter id
                $encounterId = $encounter->encounter_id;
                // 3. tanggal periksa
                $timestampArrived = Carbon::parse($encounter->created_at)->format('Y-m-d\TH:i:sP');
                $timestampAwal = Carbon::parse($timestampArrived)->addMinutes(5)->format('Y-m-d\TH:i:sP');
                $timestampAkhir = Carbon::parse($timestampAwal)->addMinutes(30)->format('Y-m-d\TH:i:sP');
                $timeFinished = Carbon::parse($timestampAwal)->addMinutes(61)->format('Y-m-d\TH:i:sP');


                // cari encounter ss by encounter id
                $client = new OAuth2Client;
                // Encounter
                [$statusCodeId, $responseId] = $client->get_by_id('Encounter', $encounterId);

                $encounter = new Encounter;
                $encounter->put($encounterId);
                $encounter->addRegistrationId($condition->kode_register);
                $encounter->setArrived($timestampArrived);
                $encounter->setInProgress($timestampAwal, $timestampAkhir);
                $encounter->setFinished($timeFinished);
                $encounter->setConsultationMethod('RAJAL');
                // Ambil ID dari subject
                $patientId = explode('/', $responseId->subject->reference)[1];
                $encounter->setSubject($patientId, $responseId->subject->display);
                // Ambil ID dari participant
                $participantId = explode('/', $responseId->participant[0]->individual->reference)[1];
                $encounter->addParticipant($participantId, $responseId->participant[0]->individual->display);
                // Ambil ID dari location
                $locationId = explode('/', $responseId->location[0]->location->reference)[1];
                $encounter->addLocation($locationId, $responseId->location[0]->location->display);
                $encounter->addDiagnosis($conditionId, $kodeDoagnosa);

                $body = $encounter->json();
                [$statusCode, $response] =  $client->ss_put('Encounter', $encounterId, $body);
                // dd($statusCode, $response);
                if ($statusCode == 200) {
                    // update local encounter 
                    $localEncounter = LocalEncounter::where('encounter_id', $encounterId)
                        ->first();
                    $updated = Carbon::parse($timestampAwal)
                        ->addMinutes(61)
                        ->format('Y-m-d\TH:i:sP');
                    $localEncounter->update([
                        'status' => $response->status,
                        'updated_at' => $updated
                    ]);

                    $this->info('Encounter Updated finished successfully sent to Satu Sehat.');
                } else {
                    $this->error('Encounter Updated finished Failed sent to Satu Sehat.');
                }
            }
        }
    }
}

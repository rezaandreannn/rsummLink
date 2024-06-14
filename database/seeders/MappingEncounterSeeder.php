<?php

namespace Database\Seeders;

use App\Models\MappingEncounter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MappingEncounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mpEncounters = DB::connection('seed')->table('mapping_encounters')->get();

        foreach ($mpEncounters as $item) {
            MappingEncounter::create([
                'kode_dokter' => $item->kode_dokter,
                'practitioner_ihs' => $item->practitioner_ihs,
                'practitioner_display' => $item->practitioner_display,
                'location_id' => $item->location_id,
                'location_display' => $item->location_display,
                'organization_id' => $item->organization_id,
                'type' => $item->type,
                'status' => $item->status,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by
            ]);
        }
    }
}

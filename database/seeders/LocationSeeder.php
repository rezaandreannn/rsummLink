<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $locations = DB::connection('seed')->table('locations')->get();

        // foreach ($locations as $item) {
        //     Location::create([
        //         'location_id' => $item->location_id,
        //         'name' => $item->name,
        //         'status' => $item->status,
        //         'organization_id' => $item->organization_id,
        //         'description' => $item->description,
        //         'part_of' => $item->part_of,
        //         'created_by' => $item->created_by,
        //         'updated_by' => $item->updated_by
        //     ]);
        // }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations = DB::connection('seed')->table('organizations')->get();

        foreach ($organizations as $item) {
            Organization::create([
                'organization_id' => $item->organization_id,
                'active' => $item->active,
                'name' => $item->name,
                'part_of' => $item->part_of,
                'created_by' => $item->created_by,
                'updated_by' => $item->updated_by
            ]);
        }
    }
}

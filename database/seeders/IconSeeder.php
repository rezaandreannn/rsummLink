<?php

namespace Database\Seeders;

use App\Models\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jsonPath = database_path('seeders/json/icons.json');

        $jsonData = File::get($jsonPath);
        $icons = json_decode($jsonData, true);

        $insertData = [];
        foreach ($icons as $key => $icon) {
            $insertData[] = [
                'class' => 'fas fa-' . $key,
                'label' => ucfirst(str_replace('-', ' ', $key)),
            ];
        }

        foreach ($insertData as $value) {
            Icon::create([
                'class' => $value['class'],
                'label' => $value['label']
            ]);
        }
    }
}

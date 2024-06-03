<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            [
                'name' => 'dashboard',
                'route' => 'dashboard',
                'icon' => '',
                'is_superadmin' => 1
            ],
            [
                'name' => 'manajemen pengguna',
                'icon' => '',
                'is_superadmin' => 1
            ],
            [
                'name' => 'Master Data',
                'icon' => '',
                'application_id' => 1,
                'is_superadmin' => 0
            ],
            [
                'name' => 'Encounter',
                'route' => 'encounter',
                'icon' => '',
                'application_id' => 1,
                'is_superadmin' => 0
            ]
        ];
        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // find menu menajemen pengguna
        $menu = Menu::where('name', 'manajemen pengguna')->first();

        $menuItems = [
            [
                'name' => 'User',
                'route' => '',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Role',
                'route' => '',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Permission',
                'route' => '',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Menu',
                'route' => '',
                'menu_id' => $menu->id
            ],
        ];

        foreach ($menuItems as $menu) {
            MenuItem::create($menu);
        }
    }
}

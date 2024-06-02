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
                'route' => 'users.index',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Role',
                'route' => 'role.index',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Permission',
                'route' => 'permission.index',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Menu',
                'route' => 'menu.index',
                'menu_id' => $menu->id
            ],
            [
                'name' => 'Location',
                'route' => '',
                'menu_id' => 3
            ],
        ];

        foreach ($menuItems as $menu) {
            MenuItem::create($menu);
        }
    }
}

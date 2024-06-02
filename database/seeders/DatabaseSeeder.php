<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Icd10Seeder;
use Satusehat\Integration\Terminology\Icd10;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(Icd10Seeder::class);
        $this->call(Icd9cmSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ApplicationSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserHasRoleSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(MenuItemSeeder::class);
    }
}

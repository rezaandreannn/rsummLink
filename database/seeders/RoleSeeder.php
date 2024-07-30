<?php

namespace Database\Seeders;

use App\Models\Application;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $appSatuSehat = Application::where('prefix', 'satu-sehat')->first();
        $appVclaim = Application::where('prefix', 'v-claim')->first();

        $roles = [
            [
                'name' => 'superadmin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'application_id' => $appSatuSehat->id
            ],
            [
                'name' => 'user',
                'guard_name' => 'web',
                'application_id' => $appSatuSehat->id
            ],
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'application_id' => $appVclaim->id
            ],
            [
                'name' => 'pendaftaran',
                'guard_name' => 'web',
                'application_id' => $appVclaim->id
            ],
            [
                'name' => 'user',
                'guard_name' => 'web',
                'application_id' => $appVclaim->id
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Application;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserHasRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //disini kita assign user id 2 menjadi role di app satusehat sebagai admin dan di vclaim menjadi pendaftaran
        // definisikan application id
        $satusehat = Application::where('prefix', 'satusehat')->first();
        $vclaim = Application::where('prefix', 'v-claimbpjs')->first();

        // definisikan user 
        $user = User::find(2);
        $superadminUser = User::find(1);

        // definisikan role nya
        $adminRole = Role::where(
            [
                'name' => 'user',
                'application_id' => $satusehat->id
            ]
        )->first();

        $pendaftaranRole = Role::where(
            [
                'name' => 'admin',
                'application_id' => $vclaim->id
            ]
        )->first();

        $superadminRole = Role::where(
            [
                'name' => 'superadmin',
            ]
        )->first();


        // sekarang kita assign usernya
        $user->assignRole([$adminRole, $pendaftaranRole]);
        $superadminUser->assignRole($superadminRole);
    }
}

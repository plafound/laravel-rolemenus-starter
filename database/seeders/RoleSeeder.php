<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roleSuperadmin = Role::create([
            'role_code' => 'superadmin',
            'role_name' => 'Super Admin'
        ]);

        $roleAdmin = Role::create([
            'role_code' => 'admin',
            'role_name' => 'Administrator'
        ]);
        $roleMahasiswa = Role::create([
            'role_code' => 'mahasiswa',
            'role_name' => 'Mahasiswa'
        ]);

        $userSuperadmin = User::factory()->create([
            'name' => ' superadmin user',
            'email' => 'superadmin@mail.com',
            'username' => 'superadmin',
            'password' => bcrypt('12345678'),
            'role_id' => $roleSuperadmin->id,
            'user_type' => 'superadmin'
        ]);
        $userAdmin = User::factory()->create([
            'name' => ' admin user',
            'email' => 'admin@mail.com',
            'username' => 'admin',
            'password' => bcrypt('12345678'),
            'role_id' => $roleAdmin->id,
            'user_type' => 'admin_kelas'
        ]);

        $userAdmin = User::factory()->create([
            'name' => ' mahasiswa',
            'email' => 'mahasiswa@mail.com',
            'username' => 'mahasiswa',
            'password' => bcrypt('12345678'),
            'role_id' => $roleMahasiswa->id,
            'user_type' => 'mahasiswa',
        ]);
    }
}

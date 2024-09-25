<?php

namespace Roelvanlierop\Usermanager\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User permissions
        $mUser = User::create([
            'name' => 'Super Admin',
            'email' => 'administrator@usermanager.xyz',
            'password' => Hash::make('ABCDEFGH')
        ]);

        $mTeam = Teams::create([
            'team_name' => 'System Administration'
        ]);

        $mRole = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'web',
            'team_id' => 1
        ]);

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        setPermissionsTeamId(1);
        session( ['team_id' => 1 ] );
        $mUser->assignRole($mRole);
    }
}

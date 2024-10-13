<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Maak de permissies aan
        $permissions = [
            'view admin menu',
            'hikestafmenu weergeven',
            'posten aanpassen',
            'posten bekijken',
            'deelnemers aanpassen',
            'deelnemers uitgebreid bekijken',
            'deelnemers naam bekijken',
            'basis1',
            'post moments',
            'manage permissions',    // Nieuwe permissie
            'manage users',          // Nieuwe permissie
            'opensluit post',        // Nieuwe permissie
            'edit post',             // Nieuwe permissie
            'group checkin',         // Nieuwe permissie
            'assign points',         // Nieuwe permissie
            'post comments',
            'bekijk puntenoverzicht A',
            'bekijk puntenoverzicht B',
            'bekijk puntenoverzicht C',
            'bekijk puntenoverzicht D',
            'bekijk puntenoverzicht E',
            'bekijk puntenoverzicht F',
            'koppel beheer A',
            'koppel beheer B',
            'koppel beheer C',
            'koppel beheer D',
            'koppel beheer E',
            'koppel beheer F',
            'posten beheer A',
            'posten beheer B',
            'posten beheer C',
            'posten beheer D',
            'posten beheer E',
            'posten beheer F',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Maak de rollen aan
        $roles = [
            'admin',
            'hikestafa',
            'hikestafb',
            'hikestafc',
            'hikestafd',
            'hikestafe',
            'hikestaff',
            'kampstaf',
            'kookploeg',
            'bouwploeg',
            'werkploeg',
            'superadmin',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Hier kun je permissies toekennen aan specifieke rollen
        // Bijvoorbeeld: admin rol krijgt alle permissies
        $adminRole = Role::findByName('admin');
        $adminRole->givePermissionTo(Permission::all());

        // Superadmin krijgt ook alle permissies
        $superAdminRole = Role::findByName('superadmin');
        $superAdminRole->givePermissionTo(Permission::all());

        // Werkploeg mag bijvoorbeeld alleen posten bekijken en deelnemers naam zien
        $werkploegRole = Role::findByName('werkploeg');
        $werkploegRole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'post moments']);

        // Voeg meer permissies toe aan andere rollen zoals nodig
        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestafa');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht A', 'koppel beheer A', 'posten beheer A',]);

        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestafb');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht B', 'koppel beheer B', 'posten beheer B',]);

        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestafc');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht C', 'koppel beheer C', 'posten beheer C',]);

        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestafd');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht D', 'koppel beheer D', 'posten beheer D',]);

        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestafe');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht E', 'koppel beheer E', 'posten beheer E',]);

        // Bijvoorbeeld voor hikestaf A
        $hikestafARole = Role::findByName('hikestaff');
        $hikestafARole->givePermissionTo(['posten bekijken', 'deelnemers naam bekijken', 'hikestafmenu weergeven', 'posten aanpassen', 'deelnemers aanpassen', 'post moments', 'bekijk puntenoverzicht F', 'koppel beheer F', 'posten beheer F',]);

        // Kampstaf krijgt specifieke permissies
        $kampstafRole = Role::findByName('kampstaf');
        $kampstafRole->givePermissionTo([
            'posten bekijken', 
            'deelnemers naam bekijken',
            'hikestafmenu weergeven', 
            'posten aanpassen', 
            'deelnemers aanpassen',
            'manage users',
            'opensluit post',
            'edit post',
            'group checkin',
            'assign points',
            'post moments',
            'post comments',
            'bekijk puntenoverzicht A', 'koppel beheer A', 'posten beheer A',
            
        ]);
    }
}
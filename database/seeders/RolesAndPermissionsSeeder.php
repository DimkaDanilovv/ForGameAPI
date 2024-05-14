<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]
        ->forgetCachedPermissions();

        // $readLocation = 'read location';
        $deleteLocation = 'delete location';
        $editLocation = 'edit location';
        $createLocation = 'create location';
        // $sortingLocation = 'sorting location';
        // $filtrateLocation = 'filtrate location';
        $viewLocation = 'view location';

        // $readBoss = 'read boss';
        $deleteBoss = 'delete boss';
        $editBoss = 'edit boss';
        $createBoss = 'create boss';
        // $sortingBoss = 'sorting boss';
        // $filtrateBoss = 'filtrate boss';
        $viewBoss = 'view boss';

        // $readFaction = 'read faction';
        $deleteFaction = 'delete faction';
        $editFaction = 'edit faction';
        $createFaction = 'create faction';
        // $sortingFaction = 'sorting faction';
        // $filtrateFaction = 'filtrate faction';
        $viewFaction = 'view faction';

        // $readClass = 'read class';
        $deleteClass = 'delete class';
        $editClass = 'edit class';
        $createClass = 'create class';
        // $sortingClass = 'sorting class';
        // $filtrateClass = 'filtrate class';
        $viewClass = 'view class';

        $addUser = 'add user';

        Permission::create(['name' => $deleteLocation]);
        Permission::create(['name' => $editLocation]);
        Permission::create(['name' => $createLocation]);
        Permission::create(['name' => $viewLocation]);

        Permission::create(['name' => $deleteBoss]);
        Permission::create(['name' => $editBoss]);
        Permission::create(['name' => $createBoss]);
        Permission::create(['name' => $viewBoss]);

        Permission::create(['name' => $deleteFaction]);
        Permission::create(['name' => $editFaction]);
        Permission::create(['name' => $createFaction]);
        Permission::create(['name' => $viewFaction]);

        Permission::create(['name' => $deleteClass]);
        Permission::create(['name' => $editClass]);
        Permission::create(['name' => $createClass]);
        Permission::create(['name' => $viewClass]);

        Permission::create(['name' => $addUser]);

        //roles
        $admin = 'admin';
        $moderator = 'moderator';
        $user = 'user';

        Role::create(['name' => $admin]) 
            ->givePermissionTo(Permission::all());

        Role::create(['name' => $moderator]) 
            ->givePermissionTo([
                $deleteLocation,
                $editLocation,
                $createLocation,
                $viewLocation,
                $deleteBoss,
                $editBoss,
                $createBoss,
                $viewBoss,
                $deleteFaction,
                $editFaction,
                $createFaction,
                $viewFaction,
                $deleteClass,
                $editClass,
                $createClass,
                $viewClass,

            ]);

        Role::create(['name' => $user]) 
            ->givePermissionTo([
                $viewLocation,
                $viewBoss,
                $viewFaction,
                $viewClass,
            ]);

    }
}

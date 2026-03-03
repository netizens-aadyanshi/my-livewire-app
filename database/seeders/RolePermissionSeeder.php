<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset Cached Roles and Permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'create posts',
            'edit own posts',
            'edit all posts',
            'delete own posts',
            'delete all posts',
            'publish posts',
            'manage users',
            'manage roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'Editor']);
        $editorRole->givePermissionTo([
            'create posts',
            'edit all posts',
            'delete all posts',
            'publish posts',
        ]);

        $authorRole = Role::create(['name' => 'Author']);
        $authorRole->givePermissionTo([
            'create posts',
            'edit own posts',
            'delete own posts',
        ]);

        $subscriberRole = Role::create(['name' => 'Subscriber']);
        // Subscribers don't get any permissions by default

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'users-list',
            'users-create',
            'users-edit',
            'users-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $owner = Role::create(['name' => 'owner']);

        $owner->syncPermissions($permissions);

        $superAdmin = Role::create(['name' => 'super-admin']);

        $superAdmin->syncPermissions([
            'users-list',
            'users-create',
            'users-edit',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'tag-list',
            'tag-create',
            'tag-edit',
            'tag-delete',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
        ]);

        $admin = Role::create(['name' => 'admin']);

        $admin->syncPermissions([
            'users-list',
            'category-list',
            'tag-list',
            'post-list',
            'post-create',
            'post-edit',
            'post-delete',
        ]);
    }
}

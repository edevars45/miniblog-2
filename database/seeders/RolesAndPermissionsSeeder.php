<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Toujours vider le cache interne de Spatie avant d'altérer la matrice
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Permissions liées aux articles (MiniBlog)
        $perms = [
            'posts.view',
            'posts.create',
            'posts.edit',
            'posts.delete',
            'posts.publish',
            'users.manage',
        ];

        foreach ($perms as $p) {
            Permission::firstOrCreate(['name' => $p]);
        }

        // Rôles
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $editor = Role::firstOrCreate(['name' => 'editor']);
        $author = Role::firstOrCreate(['name' => 'author']);
        $viewer = Role::firstOrCreate(['name' => 'viewer']);

        // Matrice rôles → permissions
        $admin->syncPermissions(Permission::all());
        $editor->syncPermissions(['posts.view', 'posts.create', 'posts.edit', 'posts.publish']);
        $author->syncPermissions(['posts.view', 'posts.create', 'posts.edit']);
        $viewer->syncPermissions(['posts.view']);

        // Rafraîchir le cache des permissions
        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
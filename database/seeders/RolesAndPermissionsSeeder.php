<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $resources = ['asset', 'work_order', 'maintenance_schedule', 'inspection', 'part', 'vendor', 'document', 'user'];
        $actions = ['view', 'create', 'update', 'delete'];

        foreach ($resources as $resource) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$action}_{$resource}"]);
            }
        }

        // Extra permissions
        Permission::firstOrCreate(['name' => 'manage_company_settings']);
        Permission::firstOrCreate(['name' => 'view_reports']);
        Permission::firstOrCreate(['name' => 'view_dashboard_full']);

        // Admin — full access
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        // Manager — everything except user management and company settings
        $manager = Role::firstOrCreate(['name' => 'manager']);
        $manager->syncPermissions(
            Permission::whereNotIn('name', [
                'create_user', 'update_user', 'delete_user',
                'manage_company_settings',
            ])->get()
        );

        // Technician — view most, edit assigned work orders, create inspections
        $technician = Role::firstOrCreate(['name' => 'technician']);
        $technician->syncPermissions([
            'view_asset',
            'view_work_order', 'update_work_order',
            'view_maintenance_schedule',
            'view_inspection', 'create_inspection', 'update_inspection',
            'view_part',
            'view_vendor',
            'view_document',
        ]);

        // Driver — view only, can create inspections
        $driver = Role::firstOrCreate(['name' => 'driver']);
        $driver->syncPermissions([
            'view_asset',
            'view_work_order',
            'view_inspection', 'create_inspection',
            'view_document',
        ]);
    }
}

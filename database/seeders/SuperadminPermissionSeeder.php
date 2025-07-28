<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\RoleHasPermission;
use Illuminate\Support\Facades\Artisan;

class SuperadminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'superadmin')->first();
        RoleHasPermission::where('role_id', $role->id)->delete();
        Artisan::call('permission:create-permission-routes');
        $permissions = Permission::pluck('id', 'id')->all();

        $data = [];
        foreach ($permissions as $permission) {
            $data[] = [
                'permission_id' => $permission,
                'role_id' => $role->id,
            ];
        }
        $role_has_permissions = RoleHasPermission::insert($data);
        $this->command->info('Superadmin Permissions Updated successfully.');
        
    }
}
        //php artisan db:seed --class=SuperadminPermissionSeeder
        //php artisan permission:create-permission-routes

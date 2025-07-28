<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class CreateShopRoutePermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::where('module_type', 4)->pluck('slug', 'id');
        Log::info("modules: " . $modules);
        $actions = ['index', 'create', 'get', 'store', 'edit', 'update', 'delete'];
        if ($modules->isNotEmpty()) {
            $permissions = []; 
            // Generate all possible routes
            $allRoutes = [];
            foreach ($modules as $id => $module) {
                foreach ($actions as $action) {
                    $allRoutes[] = "shop.$module.$action";
                }
            }
            // Fetch existing permissions for these routes
            $existingPermissions = Permission::whereIn('name', $allRoutes)
                ->pluck('name')->toArray();
            // Prepare new permissions for batch insertion
            foreach ($modules as $id => $module) {
                foreach ($actions as $action) {
                    $route = "shop.$module.$action";
                    if (!in_array($route, $existingPermissions)) {
                        $permissions[] = [
                            'name' => $route,
                            'module_id' => $id, // Use the ID from the modules
                            'guard_name' => 'web',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                }
            }

            // Batch Insert Permissions
            if (!empty($permissions)) {
                Permission::insert($permissions);
            }
            $this->command->info('Shop Route Permission added successfully.');
        } else {
            $this->command->warn('No modules found for the specified type.');
        }
    }
}
// php artisan db:seed --class=CreateShopRoutePermission
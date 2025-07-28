<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class CreateCrmModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module = Module::insert([
            [
                'name'       => 'Dashboard',
                'order'      => '10',
                'slug'       => 'dashboard',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Kunder',
                'order'      => '11',
                'slug'       => 'kunder',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Leads',
                'order'      => '12',
                'slug'       => 'leads',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Opgaver',
                'order'      => '13',
                'slug'       => 'task',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Salgssager',
                'order'      => '14',
                'slug'       => 'salgssager',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Servicesager',
                'order'      => '15',
                'slug'       => 'servicesager',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Rma',
                'order'      => '16',
                'slug'       => 'rma',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Loesninger',
                'order'      => '17',
                'slug'       => 'loesninger',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Serviceaftaler',
                'order'      => '18',
                'slug'       => 'serviceaftaler',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Abonnementer',
                'order'      => '19',
                'slug'       => 'abonnementer',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Lager',
                'order'      => '20',
                'slug'       => 'lager',
                'status'     =>  '1',
                'module_type'     =>  '2',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

        ]);
        $this->command->info('Modules created successfully.');
    }
}

// php artisan db:seed --class=CreateCrmModulesSeeder 
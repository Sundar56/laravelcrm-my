<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;

class CreateModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $module = Module::insert([
            [
                'name'       => 'Companies',
                'order'      => '1',
                'slug'       => 'companies',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Roles',
                'order'      => '2',
                'slug'       => 'roles',
                'status'     =>  '0',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Company User',
                'order'      => '3',
                'slug'       => 'companyuser',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'SSO',
                'order'      => '4',
                'slug'       => 'sso',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'CRM',
                'order'      => '5',
                'slug'       => 'crm',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'CMS',
                'order'      => '6',
                'slug'       => 'cms',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'SHOP',
                'order'      => '7',
                'slug'       => 'shop',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Admin User',
                'order'      => '8',
                'slug'       => 'adminusers',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name'       => 'Password Reset',
                'order'      => '9',
                'slug'       => 'passwordreset',
                'status'     =>  '1',
                'module_type'     =>  '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ]);
        $this->command->info('Modules created successfully.');
    }
}

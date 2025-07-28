<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {     
        $this->call([CreateUserSeeder::class]);
        $this->call([CreateModulesSeeder::class]);
        $this->call([CreateCrmModulesSeeder::class]);
        $this->call([CreateCmsModulesSeeder::class]);
        $this->call([CreateCrmRolesSeeder::class]);
        $this->call([CreateCrmRoutePermission::class]);
        $this->call([CreateCmsRoutePermission::class]);
        $this->call([CreateShopModulesSeeder::class]);
        $this->call([CreateShopRoutePermission::class]);
        $this->call([SuperadminPermissionSeeder::class]);      
    }
}

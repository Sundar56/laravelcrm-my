<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'superadmin@gmail.com')->first();
        $password =  'crmlaravel11';
        $hashPassword = Hash::make($password);
        if (empty($user)) {
            $user = User::create([
                'name'      => 'Superadmin',
                'email'     => 'superadmin@gmail.com',
                'user_displayname'     => 'SuperAdmin',
                'password'  => $hashPassword,
                // 'user_phone'  => 9876541230,                    
            ]);
            $this->command->info('Superadmin created successfully.');
            $superAdminRole = Role::create(['name' => 'superadmin', 'display_name' => 'Super Admin', 'guard_name' => 'web']);
            // $supportAdminRole = Role::create(['name' => 'supportadmin', 'display_name' => 'Support Admin', 'guard_name' => 'web']);
            $user->assignRole([$superAdminRole->id]);
        }
        //php artisan db:seed --class=CreateUserSeeder
    }
}

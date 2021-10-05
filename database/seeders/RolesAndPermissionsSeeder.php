<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // USER MODEL
        $userPermission1=Permission::create(['name' => 'create: user','description'=>'create user']);
        $userPermission2=Permission::create(['name' => 'read: user','description'=>'read user']);
        $userPermission3=Permission::create(['name' => 'update: user','description'=>'update user']);
        $userPermission4=Permission::create(['name' => 'delete: user','description'=>'delete user']);

        // ROLE MODEL
        $rolePermission1=Permission::create(['name' => 'create: role','description'=>'create role']);
        $rolePermission2=Permission::create(['name' => 'read: role','description'=>'read role']);
        $rolePermission3=Permission::create(['name' => 'update: role','description'=>'update role']);
        $rolePermission4=Permission::create(['name' => 'delete: role','description'=>'delete role']);

        // PERMISSION MODEL
        $permission1=Permission::create(['name' => 'create: permission','description'=>'create permission']);
        $permission2=Permission::create(['name' => 'read: permission','description'=>'read permission']);
        $permission3=Permission::create(['name' => 'update: permission','description'=>'update permission']);
        $permission4=Permission::create(['name' => 'delete: permission','description'=>'delete permission']);

        // ADMIN MODEL
        $adminPermission1=  Permission::create(['name' => 'read: admin','description'=>'read admin']);
        $adminPermission2=  Permission::create(['name' => 'update: admin','description'=>'update admin']);

        $superAdminRole =    Role::create(['name' => 'super-admin']);
        $adminRole      =    Role::create(['name' => 'admin']);
        $managerRole    =    Role::create(['name' => 'manager']);
        $leadRole       =    Role::create(['name' => 'lead']);
        $developerRole  =    Role::create(['name' => 'developer']);
        $userRole       =    Role::create(['name' => 'user']);


        $superAdminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);
        $adminRole->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);
        $managerRole->syncPermissions([
           
            $userPermission2,
            $rolePermission2,
            $permission2,
            $adminPermission1,
        ]);
        $leadRole->syncPermissions([
            $adminPermission1,
        ]);
        $developerRole->syncPermissions([
            $adminPermission1,
        ]);
        $userRole->syncPermissions([
            $adminPermission1,
        ]);

        $superAdmin= User::create([
            'company_name'=>'tek it solutions',
            'is_admin'=>1,
            'email'=>'company@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);
        $admin= User::create([
            'first_name'=>'admin',
            'last_name'=>'admin',
            'is_admin'=>1,
            'email'=>'admin@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);
        $manager= User::create([
            'first_name'=>'manager',
            'last_name'=>'manager',
            'is_admin'=>1,
            'email'=>'manager@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);
        $lead= User::create([
            'first_name'=>'lead',
            'last_name'=>'lead',
            'is_admin'=>1,
            'email'=>'lead@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);
        $developer= User::create([
            'first_name'=>'developer',
            'last_name'=>'developer',
            'is_admin'=>1,
            'email'=>'developer@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);
        $user= User::create([
            'first_name'=>'user',
            'last_name'=>'user',
            'is_admin'=>0,
            'email'=>'user@gmail.com',
            'email_verified_at'=>now(),
            'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
            'remember_token'=>Str::random(10),
        ]);

        $superAdmin->syncRoles([$superAdminRole])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);

        $admin->syncRoles([$adminRole])->syncPermissions([
            $userPermission1,
            $userPermission2,
            $userPermission3,
            $userPermission4,
            $rolePermission1,
            $rolePermission2,
            $rolePermission3,
            $rolePermission4,
            $permission1,
            $permission2,
            $permission3,
            $permission4,
            $adminPermission1,
            $adminPermission2,
        ]);
        $manager->syncRoles($managerRole)->syncPermissions([
            $userPermission2,
            $rolePermission2,
            $permission2,
            $adminPermission1,
        ]);
        $lead->syncRoles($leadRole)->syncPermissions([
            
            $adminPermission1,
        ]);
        $developer->syncRoles($developerRole)->syncPermissions([
            
            $adminPermission1,
        ]);
        $user->syncRoles($userRole);
    }
}

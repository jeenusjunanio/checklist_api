<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10; $i++) { 
            $user=User::create([
                'first_name'=>'test'.$i,
                'last_name'=>'user'.$i,
                'is_admin'=>0,
                'provider_id'=>NULL,
                'email'=>'test'.$i.'@gmail.com',
                'email_verified_at'=>now(),
                'password'=>'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', //password
                'remember_token'=>Str::random(10),
            ]);
            $role=Role::where('id',6)->first();
            $user->syncRoles($role);
        }
    }
}

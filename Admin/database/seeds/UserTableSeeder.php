<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Roles;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = Roles::where('name','User')->first();
        $role_admin = Roles::where('name','Admin')->first();

        $user = new User();
        $user->first_name = 'Ali';
        $user->email = 'ali@mail.com';
        $user->password = bcrypt('Admin123@');
        $user->status = 0;
        $user->save();
        $user->roles()->attach($role_user);

        $admin = new User();
        $admin->first_name = 'Arif';
        $admin->email = 'admin@mail.com';
        $admin->password = bcrypt('Admin123@');
        $admin->status = 1;
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}

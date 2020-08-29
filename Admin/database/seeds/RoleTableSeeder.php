<?php

use Illuminate\Database\Seeder;
use App\Models\Roles;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_user = new Roles();
        $role_user->name = 'User';
        $role_user->discription = 'Normal User';
        $role_user->save();

        $role_admin = new Roles();
        $role_admin->name = 'Admin';
        $role_admin->discription = 'Admin Control All Content';
        $role_admin->save();
    }
}

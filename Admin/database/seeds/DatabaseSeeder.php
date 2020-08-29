<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ChildrenGroupTableSeeder::class);
        $this->call(ChildrenHouseHoldTableSeeder::class);
        $this->call(EducationTableSeeder::class);
        $this->call(HouseHoldCategoryTableSeeder::class);
        $this->call(HouseHoldSubCategoryTableSeeder::class);
        $this->call(OccupationTableSeeder::class);
        $this->call(RolePurchasingTableSeeder::class);
    }
}

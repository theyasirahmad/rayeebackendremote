<?php

use Illuminate\Database\Seeder;
use App\Models\house_hold_category;

class HouseHoldCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            'Grocery',
            'Baby',
            'Chilled & Frozen',
            'Drinks',
            'Health & Beauty',
            'Household',
            'Tobacco'
        ];

        foreach($category as $cat){
            house_hold_category::create([
                'title' => $cat
            ]);
        }
    }
}

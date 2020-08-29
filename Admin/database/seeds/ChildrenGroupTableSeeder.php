<?php

use Illuminate\Database\Seeder;
use App\Models\children_group;

class ChildrenGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $children = ['Baby 0-2 years', 'Child 3-6 years',
                     'Child 7-9 years', 'Child 10-12 years', 'Teens 13-17 years'];
        foreach($children as $child){
            children_group::create([
                'title' => $child
            ]);
        }
    }
}

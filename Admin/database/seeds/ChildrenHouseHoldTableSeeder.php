<?php

use Illuminate\Database\Seeder;
use App\Models\children_household;

class ChildrenHouseHoldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $children = [
            'Diapers / Wipes',
            'Babyfood (Cerelac , Bisuits etc)',
            'Infant Milk Formula (Specially designed for babies (0-6 months)',
            'Follow on Milk Formula (Specially designed for babies 7 -12 months)',
            'Growing up Milk ( Specially deisgned for children over 1 year old)',
            'Milk based nutritional developmenets designed for 1-10 year old kids',
            "Fresh / UHT Milk (Cow's milk that is refrigerated or stored in long life containers)",
            'Full Cream Milk Powder ( Powdered plain milk in tin/carton/plastic packs that can be diluted in water O32 It is usually consumed by both adults as well as kids.'
        ];

        foreach($children as $child){
            children_household::create([
                'title' => $child
            ]);
        }
    }
}

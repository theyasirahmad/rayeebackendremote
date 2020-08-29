<?php

use Illuminate\Database\Seeder;
use App\Models\occupation;

class OccupationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $occupation = [
            'Unskilled worker',
            'Petty Trader',
            'Skilled worker',
            'Non Executive Staff',
            'Supervisior',
            'Small Shopkeeper ',
            'Lower Executive Officer',
            'Self Employed  / Services Provider',
            'Professional / Doctor /Lawyer etc',
            'Senior Executive / Manager level',
            'Medium Businessman',
            'Large Businessman / Factory owner',
            'Housewife',
            'Student',
        ];

        foreach($occupation as $occ){
            occupation::create([
                'title' => $occ
            ]);
        }
    }
}

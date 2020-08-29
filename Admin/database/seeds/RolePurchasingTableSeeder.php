<?php

use Illuminate\Database\Seeder;
use App\Models\role_purchasing;

class RolePurchasingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $purchasing = [
            'Almost all the time',
            'Half or more than half the time',
            'Less than half the time'
        ];

        foreach($purchasing as $pur){
            role_purchasing::create([
                'title' => $pur
            ]);
        }
    }
}

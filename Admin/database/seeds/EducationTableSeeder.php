<?php

use Illuminate\Database\Seeder;
use App\Models\education;

class EducationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $education = [
            'Illetrate / no Education',
            'Less than Primary (up to 4th grade in school)',
            'Between primary and Matric (School 5 to 9 years)',
            'Matric (10 years of school)',
            'Intermediate',
            'Graduate B.Com / B.Sc / BA',
            'Post Graduate M.Com / M.Sc / MA'
        ];

        foreach($education as $edu){
            education::create([
                'title' => $edu
            ]);
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveySubCategory extends Model
{
    public function mainCategory()
    {
        return $this->belongsTo('App\Models\SurveyCategory', 'main_category');
    }
}

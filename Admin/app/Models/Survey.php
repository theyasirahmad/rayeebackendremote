<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Models\SurveyCategory', 'main_category');
    }

    public function subCategory()
    {
        return $this->belongsTo('App\Models\SurveySubCategory', 'sub_category');
    }

    public function costing()
    {
        return $this->belongsTo('App\Models\Costing', 'cost');
    }
}

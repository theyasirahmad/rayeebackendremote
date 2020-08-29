<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyPublish extends Model
{
    public function survey()
    {
        return $this->belongsTo('App\Models\Survey', 'survey');
    }
    
    public function surveyPublish()
    {
        return $this->belongsTo('App\Models\Survey', 'survey');
    }

    public function education()
    {
        return $this->belongsTo('App\Models\education', 'education');
    }

    public function occupation()
    {
        return $this->belongsTo('App\Models\occupatio', 'occupation');
    }

    public function children_group()
    {
        return $this->belongsTo('App\Models\children_group', 'children_group');
    }

    public function children_household()
    {
        return $this->belongsTo('App\Models\children_household', 'children_household');
    }

    public function household_category()
    {
        return $this->belongsTo('App\Models\house_hold_sub_category', 'household_category');
    }

    public function purchasing_role()
    {
        return $this->belongsTo('App\Models\role_purchasing', 'purchasing_role');
    }
}

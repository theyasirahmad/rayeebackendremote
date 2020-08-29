<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyPublishCities extends Model
{
    protected $fillable = [ 'city', 'city_name', 'publishTo', 'survey' ];
}

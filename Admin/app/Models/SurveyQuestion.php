<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{   
    protected $fillable = ['survey','question','questionType','content','status','user'];

    public function survey()
    {
        return $this->belongsTo('App\Models\SurveyAnswer', 'questionID');
    }
}

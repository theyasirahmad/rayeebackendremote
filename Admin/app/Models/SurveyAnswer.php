<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    protected $fillable = ['answerType','content','questionID','user','grid_question_id','none','exit_ans'];
}

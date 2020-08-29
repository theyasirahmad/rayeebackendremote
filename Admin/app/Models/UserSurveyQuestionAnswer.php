<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSurveyQuestionAnswer extends Model
{
    protected $fillable = ['questionId','questionType','gridQuestion',
                            'answerID','answerType','survey','user','answer_value'];
}

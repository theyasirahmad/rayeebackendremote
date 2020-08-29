<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class house_hold_sub_category extends Model
{
    protected $table = 'house_hold_sub_category';
    protected $fillable = ['title','main_cat'];
}

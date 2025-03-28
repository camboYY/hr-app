<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{
    protected $fillable = ['goal_id', 'employee_id', 'feedback_title', 'given_by_user_id', 'given_date'];
}

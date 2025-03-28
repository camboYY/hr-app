<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeGoal extends Model
{
    protected $fillable = ['employee_id', 'goal_id', 'category_id', 'assigned_date','complete_date', 'progress'];
}

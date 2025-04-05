<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeGoal extends Model
{
    protected $fillable = ['employee_id', 'goal_id', 'category_id', 'assigned_date','complete_date', 'progress'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    public function goal()
    {
        return $this->belongsTo(Goal::class, 'goal_id');
    }
    public function category()
    {
        return $this->belongsTo(GoalCategory::class, 'category_id');
    }
}

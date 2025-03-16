<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLeave extends Model
{
    protected $table = "employee_leaves";
    
    protected $fillable = [
        'employee_id',
        'leave_type_setting_id',
        'leave_status_id',
        'approver_id',
        'reason',
        'fromDate',
        'toDate'
    ];
}

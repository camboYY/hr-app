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
        'relief_id',
        'reason',
        'fromDate',
        'toDate'
    ];

    public function leaveStatus()
    {
        return $this->belongsTo(LeaveStatus::class, 'leave_status_id');
    }
    public function leaveTypeSetting()
    {
        return $this->belongsTo(LeaveTypeSetting::class, 'leave_type_setting_id');
    }
    public function relief()
    {
        return $this->belongsTo(Employee::class,'relief_id');
    }
}

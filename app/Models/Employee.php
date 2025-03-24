<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'phoneNumber',
        'currentAddress',
        'nationalId',
        'maritalStatus',
        'dateOfBirth',
        'gender',
        'medicalCertificate',
        'line_manager_id',
        'designation_id'
    ];

     public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,"user_id");
    }

    public function leaves():HasMany
    {
        return $this->hasMany(EmployeeLeave::class)->with(["leaveStatus", "leaveTypeSetting","relief"]);
    }
    
}

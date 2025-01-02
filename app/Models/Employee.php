<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'firstName',
        'lastName',
        'middleName',
        'phoneNumber',
        'currentAddress',
        'nationalId',
        'marriageStatus',
        'dateOfBirth',
        'gender',
        'medicalCertificate',
    ];

}

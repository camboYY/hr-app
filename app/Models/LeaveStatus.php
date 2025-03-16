<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveStatus extends Model
{
    protected $fillable =[
        'reason',
        'date',
        'status'
    ];
}

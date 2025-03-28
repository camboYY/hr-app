<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    protected $fillable = ['title', 'start_date', 'end_date', 'description', 'status' ];
}

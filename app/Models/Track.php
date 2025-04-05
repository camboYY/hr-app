<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $fillable = [
        'goal_id',
        'track_by',
        'meet_target_amount',
        'exceed_target_amount',
        'significant_exceed_target_amount',
        'actual_archievement_amount',
        'reviewed_by_id'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Designation extends Model
{
    
    protected $fillable = [
        'name',
        'responsibilities',
        'contract_id',
    ];
    /**
     * Get the user associated with the designation.
     */
    public function User(): HasOne
    {
        return $this->hasOne(User::class);
    }
}

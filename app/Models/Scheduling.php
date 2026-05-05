<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduling extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'time'  
    ];

    public function Client(): BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }
}

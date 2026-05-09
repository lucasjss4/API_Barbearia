<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Scheduling extends Model
{
    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'client_id' 
    ];

    public function Client(): BelongsTo 
    {
        return $this->belongsTo(Client::class);
    }
}

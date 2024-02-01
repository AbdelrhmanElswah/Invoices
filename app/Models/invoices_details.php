<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class invoices_details extends Model
{
    protected $guarded=[];
    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class);
    }
    
}
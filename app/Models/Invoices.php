<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;


class Invoices extends Model
{
    use SoftDeletes;
    protected $guarded=[];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Sections::class);
    }
}
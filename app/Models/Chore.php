<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Chore extends Model
{
    //

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "assigned_to", "id");
    }
}

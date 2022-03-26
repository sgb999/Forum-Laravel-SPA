<?php

declare(strict_types=1);

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUserTrait
{
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

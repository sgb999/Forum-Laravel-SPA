<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id_1',
      'user_id_2'
    ];

    public function user(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users');
    }
}

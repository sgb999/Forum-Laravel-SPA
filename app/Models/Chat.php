<?php

declare(strict_types=1);

namespace App\Models;

//use App\Http\Traits\DateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Chat extends Model
{
    use HasFactory;
    //use DateTrait;

    protected $fillable = [
        'user_id_1',
        'user_id_2',
    ];

    public function user() : BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users');
    }
}

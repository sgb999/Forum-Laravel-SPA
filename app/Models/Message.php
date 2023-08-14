<?php

declare(strict_types=1);

namespace App\Models;

//use App\Http\Traits\DateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;
  //  use DateTrait;

  //  use DateTrait;

    protected $fillable = [
        'chat_id',
        'message',
        'user_id',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function chat() : BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }
}

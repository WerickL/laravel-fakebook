<?php

namespace App\Models;

use Api\User\Model\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        "description"
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

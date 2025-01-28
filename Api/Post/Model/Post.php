<?php

namespace Api\Post\Model;

use Api\File\Model\File;
use Api\User\Model\User;
use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use PostStatusEnum;

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
    protected static function newFactory(): Factory
    {
        return PostFactory::new();
    }
    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
    protected function casts(): array
    {
        return [
            'status' => PostStatusEnum::class,
        ];
    }
}

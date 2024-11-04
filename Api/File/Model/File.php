<?php

namespace Api\File\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        "description",
        "uuid",
        "name",
        "content_type"
    ];
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
}

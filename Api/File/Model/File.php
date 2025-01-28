<?php

namespace Api\File\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class File extends Model
{
    use HasFactory;
    protected $fillable = [
        "description",
        "uuid",
        "name",
        "content_type",
        "fileable_id",
        "fileable_type"
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            $file->uuid = Uuid::uuid4();
        });
    }
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }
    public function setContent($content): bool
    {
        return Storage::put($this->getFilePath(), $content);
    }
    public function getContent()
    {
        return Storage::exists($this->getFilePath())
            ? Storage::get($this->getFilePath())
            : null;
    }
    public function getFilePath(): string
    {
        return "files/{$this->uuid}";
    }
    public function deleteContent(): bool
    {
        return Storage::delete($this->getFilePath());
    }
}
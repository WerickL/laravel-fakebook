<?php 
namespace Api\File\Model;

class FileDto{
    public function __construct(
        public string $name,
        public string $content_type,
        public ?string $description,
        public ?int $fileable_id,
        public ?string $fileable_type)
    {
    }
    
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            $data['content_type'],
            $data['description'] ?? null,
            $data['fileable_id'] ?? null,
            $data['fileable_type'] ?? null
        );
    }
    public function toArray(): Array
    {
        return get_object_vars($this);
    }
}
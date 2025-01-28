<?php 
namespace Api\File\Repository;

use Api\File\Model\File;
use Api\File\Model\FileDto;
use Illuminate\Support\Facades\DB;

class FileRepository implements IFileRepository{
    public function create(FileDto $data): File
    {
        return DB::transaction(function () use ($data) {
            return File::create($data->toArray());
        });
    }

    public function findByUuid(string $uuid): ?File
    {
        return File::where('uuid', $uuid)->first();
    }

    public function update(File $file, array $data): bool
    {
        return $file->update($data);
    }

    public function delete(File $file): bool
    {
        return DB::transaction(function () use ($file) {
            $file->deleteContent();
            return $file->delete();
        });
    }

    public function setContent(File $file, $content): bool
    {
        return $file->setContent($content);
    }

    public function getContent(File $file)
    {
        return $file->getContent();
    }
}
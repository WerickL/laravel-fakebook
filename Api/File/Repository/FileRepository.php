<?php 
namespace Api\File\Repository;

use Api\File\Model\File;
use Api\File\Model\FileDto;
use Illuminate\Support\Facades\DB;

class FileRepository implements IFileRepository{
    public function create(FileDto $data): File
    {
        return DB::transaction(function () use ($data) {
                $file = File::create($data->toArray());
                if ($data->fileable_id) {
                    $modelClass = "Api\\{$data->fileable_type}\\Model\\{$data->fileable_type}";

                if (!class_exists($modelClass)) {
                    throw new \Exception("Model {$data->fileable_type} não existe");
                }

                $fileable = $modelClass::find($data->fileable_id);

                if (!$fileable) {
                    throw new \Exception("Entidade {$data->fileable_type} com ID {$data->fileable_id} não encontrada");
                }

                $file->fileable()->associate($fileable);
                $file->fileable_type = $data->fileable_type;
                $file->save();
            }
            return $file;
        });
    }

    public function findByUuid(string $uuid): ?File
    {
        try {
            $file = File::where('uuid', $uuid)->firstOrFail();
            return $file;
        } catch (\Throwable $th) {
            throw $th;
        }
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

    public function setContent(File $file, $content): null|string
    {
        $filename = $file->getFilePath();
        return  $content->storeAs('', $filename, 'public');
    }

    public function getContent(File $file)
    {
        return $file->getContent();
    }
}
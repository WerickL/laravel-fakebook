<?php 
namespace Api\File\Repository;

use Api\File\Model\File;
use Api\File\Model\FileDto;

interface IFileRepository{
    public function create(FileDto $fileData):File;
    public function delete(File $file):bool;
    public function findByUuid(string $uuid): ?File;
    public function update(File $file, array $data): bool;
    public function setContent(File $file, $content): null|string;
    public function getContent(File $file);
}
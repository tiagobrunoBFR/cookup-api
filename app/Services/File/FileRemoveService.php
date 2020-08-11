<?php

namespace App\Services\File;

use App\Models\File;
use Illuminate\Support\Facades\Storage;

class FileRemoveService
{
    private $file;
    private $path;
    public function __construct(File $file, string $path)
    {
        $this->file = $file;
        $this->path = $path;
    }

    public function __invoke()
    {
        $this->deleteFilePath();
        $this->deleteFileDatabase();
    }

    public function deleteFileDatabase()
    {
        $this->file->delete();
    }

    public function deleteFilePath()
    {
        Storage::delete($this->file->path);
    }
}

<?php


namespace App\Services\File;


use App\Models\File;

class FileUploadService
{

    private $path;
    private $file;
    private $disk;

    public function __construct($path, $file, $disk = 'public')
    {
        $this->path = $path;
        $this->file = $file;
        $this->disk = $disk;
    }


    public function __invoke()
    {
        return $this->upload();
    }

    public function upload()
    {
        $path = $this->file->store($this->path, $this->disk);

        return $this->store($path);
    }

    public function store($path)
    {
        return File::create([
            'mime' => $this->file->getClientMimeType(),
            'path' => $path,
            'name' => $this->file->getClientOriginalName(),
            'size' => $this->file->getSize()
        ]);
    }


}

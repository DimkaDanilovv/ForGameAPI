<?php

namespace App\Http\Services;


use Illuminate\Support\Str;

class FileService
{
    public function fileUpload($file, $folderPath, $title)
    {
        $slug = Str::slug(pathinfo($title, PATHINFO_FILENAME));
        $extension = $file->getClientOriginalExtension();

        $fileName = $slug . "-" . uniqid() . "." . $extension;
        $file->move(public_path("uploads/$folderPath"), $fileName);

        return "uploads/" . $folderPath . $fileName;
    }
}

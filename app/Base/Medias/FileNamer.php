<?php

namespace App\Base\Medias;

use Illuminate\Support\Str;
use Spatie\MediaLibrary\Support\FileNamer\DefaultFileNamer;

class FileNamer extends DefaultFileNamer
{
    public function originalFileName(string $fileName): string
    {
        return Str::slug($fileName);
    }
}

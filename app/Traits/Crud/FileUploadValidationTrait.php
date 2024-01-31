<?php

namespace App\Traits\Crud;

trait FileUploadValidationTrait
{
    protected array $allowedFileTypes = [
        'image/png',
        'image/jpeg',
        'image/gif',
        'application/pdf',
    ];

    protected int $maxFileSize = 5000;
}

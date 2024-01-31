<?php

namespace App\Exceptions\FieldTypes;

use Exception;

class FieldTypeMissingException extends Exception
{
    public function __construct($classname)
    {
        $this->message  = 'FieldType ' . $classname . ' does not exist';
    }
}

<?php

namespace App\Exceptions\FieldTypes;

use Exception;

class InvalidFieldTypeException extends Exception
{
    public function __construct($classname)
    {
        $this->message = 'Class "' . $classname . '" does not implement the FieldType interface.';
    }
}

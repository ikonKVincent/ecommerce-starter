<?php

namespace App\Base;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{
    /**
     * Create a new instance of the Model.
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('akawam.database.table_prefix') . $this->getTable());

        if ($connection = config('akawam.database.connection', false)) {
            $this->setConnection($connection);
        }
    }
}

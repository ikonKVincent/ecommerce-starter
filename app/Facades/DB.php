<?php

namespace App\Facades;

use Illuminate\Support\Facades\DB as DBFacade;

class DB extends DBFacade
{
    /**
     * Get the registered DatabaseManger class.
     *
     * @return \Lunar\Managers\DatabaseManager
     */
    public static function connection()
    {
        // return custom connection
        return parent::connection(config('akawam.database.connection'));
    }
}

<?php

namespace App\Base;

use Illuminate\Database\Migrations\Migration as BaseMigration;

abstract class Migration extends BaseMigration
{
    /**
     * Migration table prefix.
     */
    protected string $prefix = '';

    /**
     * Create a new instance of the migration.
     */
    public function __construct()
    {
        $this->prefix = config('akawam.database.table_prefix');
    }

    /**
     * Use the connection specified in config.
     */
    public function getConnection(): ?string
    {
        if ($connection = config('akawam.database.connection', false)) {
            return $connection;
        }

        return parent::getConnection();
    }
}

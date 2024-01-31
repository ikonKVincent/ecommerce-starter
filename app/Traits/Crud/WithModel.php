<?php

namespace App\Traits\Crud;

trait WithModel
{
    protected string $model;

    /**
     * Set Model for CRUD operations
     * @return void
     */
    abstract public function setModel(): void;
}

<?php

namespace App\Traits\Crud;

trait CrudTrait
{
    use WithModel;

    /** @locked  */
    protected string $route;

    /** @locked  */
    protected string $view;

    /**
     * Set route for CRUD operations
     */
    abstract public function setRoute(): void;

    /**
     * Set view for CRUD operations
     */
    abstract public function setView(): void;
}

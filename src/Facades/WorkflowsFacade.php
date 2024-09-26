<?php

namespace LaravelCompany\Mail\Facades;

use Illuminate\Support\Facades\Facade;

/**
 *
 */
class WorkflowsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'workflows';
    }
}

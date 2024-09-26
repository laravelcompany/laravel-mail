<?php

namespace LaravelCompany\Mail\Facades;

use Illuminate\Support\Facades\Facade;

class Helper extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-mail.helper';
    }
}

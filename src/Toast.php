<?php

namespace godforhire\Toast;

use Illuminate\Support\Facades\Facade;

class Toast extends Facade
{
    /**
     * Get the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'toast';
    }
}
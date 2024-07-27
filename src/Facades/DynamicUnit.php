<?php

namespace SimpleCMS\DynamicUnit\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \SimpleCMS\DynamicUnit\Packages\DynamicUnit
 */
class DynamicUnit extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dynamic_unit';
    }
}

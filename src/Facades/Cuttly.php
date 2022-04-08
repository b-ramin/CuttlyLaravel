<?php

namespace Bramin\CuttlyPHP\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Bramin\CuttlyPHP\CuttlyPHP
 */
class CuttlyPHP extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cuttlyphp';
    }
}

<?php

namespace Bramin\CuttlyPHP\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static ping()
 * @method static delete(string $short)
 * @method static addTag(string $short, string $tag)
 * @method static updateTitle(string $short, string $title)
 * @method static updateSource(string $short, string $source)
 * @method static getAnalytics(string $short, string $dateFrom = null, string $dateTo = null)
 * @method static create(string $short, string $name = '', bool $userDomain = null, bool $noTitle = null, bool $public = null)
 *
 * @see \Bramin\CuttlyPHP\Cuttly
 */
class Cuttly extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'cuttly';
    }
}

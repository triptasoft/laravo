<?php

namespace Triptasoft\Laravo\Facades;

use Illuminate\Support\Facades\Facade;

class Laravo extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @method static string image($file, $default = '')
     * @method static $this useModel($name, $object)
     *
     * @see \Triptasoft\Laravo\Laravo
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravo';
    }
}

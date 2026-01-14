<?php

declare(strict_types=1);

namespace TypiCMS\Modules\Events\Facades;

use Illuminate\Support\Facades\Facade;

class Events extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Events';
    }
}

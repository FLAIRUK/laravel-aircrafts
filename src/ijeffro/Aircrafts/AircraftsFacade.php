<?php

namespace ijeffro\Aircrafts;

use Illuminate\Support\Facades\Facade;

/**
 * AircraftsFacade
 *
 */
class AircraftsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'aircrafts'; }

}

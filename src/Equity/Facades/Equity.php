<?php
namespace DervisGroup\Pesa\Equity\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Equity
 * @package DervisGroup\Pesa\Equity\Facades
 */
class Equity extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'equity';
    }
}

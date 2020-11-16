<?php

namespace DervisGroup\Pesa\Equity;

use DervisGroup\Pesa\Equity\Library\StkRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class EquityServiceProvider
 * @package DervisGroup\Pesa\Equity
 */
class EquityServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('equity', function (Application $app) {
            return $app->make(StkRequest::class);
        });
    }
}

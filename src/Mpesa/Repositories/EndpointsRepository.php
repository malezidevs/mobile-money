<?php

namespace DervisGroup\Pesa\Mpesa\Repositories;

use DervisGroup\Pesa\Exceptions\MpesaException;

/**
 * Class EndpointsRepository
 *
 * @package DervisGroup\Pesa\Mpesa\Repositories
 */
class EndpointsRepository
{
    /**
     * @var EndpointsRepository
     */
    private static $instance;
    /**
     * @var string
     */
    protected $baseEndpoint;

    /**
     * EndpointsRepository constructor.
     */
    public function __construct()
    {
        $this->baseEndpoint = 'https://api.safaricom.co.ke/';
        if (\config('pesa.sandbox')) {
            $this->baseEndpoint = 'https://sandbox.safaricom.co.ke/';
        }
        $this->setInstance();
    }

    /**
     *
     */
    private function setInstance()
    {
        self::$instance = $this;
    }

    /**
     * @return EndpointsRepository
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @param string $section
     * @return string
     */
    private static function getEndpoint($section)
    {
        $list = [
            'auth' => 'oauth/v1/generate?grant_type=client_credentials',
            'id_check' => 'mpesa/checkidentity/v1/query',
            'register' => 'mpesa/c2b/v1/registerurl',
            'stk_push' => 'mpesa/stkpush/v1/processrequest',
            'stk_status' => 'mpesa/stkpushquery/v1/query',
            'b2c' => 'mpesa/b2c/v1/paymentrequest',
            'transaction_status' => 'mpesa/transactionstatus/v1/query',
            'account_balance' => 'mpesa/accountbalance/v1/query',
            'b2b' => 'mpesa/b2b/v1/paymentrequest',
            'simulate' => 'mpesa/c2b/v1/simulate',
        ];
        return $list[$section];
    }

    /**
     * @param $endpoint
     * @return string
     * @throws MpesaException
     */
    public static function build($endpoint)
    {
        $instance = self::$instance;
        $endpoint = $instance->getEndpoint($endpoint);
        return $instance->baseEndpoint . $endpoint;
    }
}

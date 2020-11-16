<?php

namespace DervisGroup\Pesa\Mpesa\Library;

use GuzzleHttp\ClientInterface;
use DervisGroup\Pesa\Mpesa\Repositories\EndpointsRepository;

/**
 * Class Core
 *
 * @package DervisGroup\Pesa\Mpesa\Library
 */
class Core
{
    /**
     * @var Core
     */
    public static $instance;
    /**
     * @var ClientInterface
     */
    public $client;
    /**
     * @var Authenticator
     */
    public $auth;

    /**
     * Core constructor.
     *
     * @param  ClientInterface $client
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     */
    public function __construct(ClientInterface $client)
    {
        $this->setClient($client);
        $this->initialize();
        self::$instance = $this;
    }

    /**
     * Initialize the Core process.
     *
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     */
    private function initialize()
    {
        new EndpointsRepository();
        $this->auth = new Authenticator($this);
    }

    /**
     * Set http client.
     *
     * @param ClientInterface $client
     **/
    public function setClient(ClientInterface $client)
    {
        $this->client = $client;
    }
}

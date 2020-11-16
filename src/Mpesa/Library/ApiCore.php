<?php

namespace DervisGroup\Pesa\Mpesa\Library;

use DervisGroup\Pesa\Exceptions\MpesaException;
use DervisGroup\Pesa\Mpesa\Repositories\EndpointsRepository;
use DervisGroup\Pesa\Repositories\Mpesa;
use GuzzleHttp\Exception\ClientException;
use Ixudra\Curl\Facades\Curl;

/**
 * Class ApiCore
 *
 * @package DervisGroup\Pesa\Mpesa\Library
 */
class ApiCore
{
    /**
     * @var Core
     */
    private $engine;
    /**
     * @var bool
     */
    public $bulk = false;
    /**
     * @var Mpesa
     */
    public $mpesaRepository;

    /**
     * ApiCore constructor.
     *
     * @param Core $engine
     * @param Mpesa $mpesa
     */
    public function __construct(Core $engine, Mpesa $mpesa)
    {
        $this->engine = $engine;
        $this->mpesaRepository = $mpesa;
    }

    /**
     * @param string $number
     * @param bool $strip_plus
     * @return string|string[]
     */
    protected function formatPhoneNumber($number, $strip_plus = true)
    {
        $number = preg_replace('/\s+/', '', $number);
        $replace = function ($needle, $replacement) use (&$number) {
            if (starts_with($number, $needle)) {
                $pos = strpos($number, $needle);
                $length = \strlen($needle);
                $number = substr_replace($number, $replacement, $pos, $length);
            }
        };
        $replace('2547', '+2547');
        $replace('07', '+2547');
        if ($strip_plus) {
            $replace('+254', '254');
        }
        return $number;
    }

    /**
     * @param array $body
     * @param string $endpoint
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeRequest($body, $endpoint)
    {
        return $this->engine->client->request(
            'POST',
            $endpoint,
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->engine->auth->authenticate($this->bulk),
                    'Content-Type' => 'application/json',
                ],
                'json' => $body,
            ]
        );
    }

    /**
     * @param array $data
     * @param string $endpoint
     * @return mixed
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makeCurlRequest($data, $endpoint)
    {
        return Curl::to($endpoint)
            ->withData($data)
            ->withHeader('Authorization: Bearer ' . $this->engine->auth->authenticate())
            ->asJson()
            ->post();
    }

    /**
     * @param array $body
     * @param string $endpoint
     * @param bool $curl
     * @return mixed
     * @throws MpesaException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function sendRequest($body, $endpoint, $curl = false)
    {
        $endpoint = EndpointsRepository::build($endpoint);
        try {
            if ($curl) {
                return $this->makeCurlRequest($body, $endpoint);
            }
            $response = $this->makeRequest($body, $endpoint);
            return \json_decode($response->getBody());
        } catch (ClientException $exception) {
            throw $this->generateException($exception);
        }
    }

    /**
     * @param ClientException $exception
     * @return MpesaException
     */
    private function generateException(ClientException $exception): MpesaException
    {
        return new MpesaException($exception->getResponse()->getBody());
    }
}

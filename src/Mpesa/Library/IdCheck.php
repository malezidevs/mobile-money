<?php

namespace DervisGroup\Pesa\Mpesa\Library;

use Carbon\Carbon;

/**
 * Class IdCheck
 *
 * @package DervisGroup\Pesa\Mpesa\Library
 */
class IdCheck extends ApiCore
{
    /**
     * @param string      $number
     * @param string|null $callback
     * @return mixed
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     */
    public function validate($number, $callback = null)
    {
        $number = $this->formatPhoneNumber($number);
        $time = Carbon::now()->format('YmdHis');
        $shortCode = \config('pesa.c2b.short_code');
        $passkey = \config('pesa.c2b.passkey');
        $defaultCallback = \config('pesa.id_validation_callback');
        $initiator = \config('pesa.initiator');
        $password = \base64_encode($shortCode . $passkey . $time);
        $body = [
            'Initiator' => $initiator,
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $time,
            'TransactionType' => 'CheckIdentity',
            'PhoneNumber' => $number,
            'CallBackURL' => $callback ?: $defaultCallback,
            'TransactionDesc' => ' '
        ];
        return $this->sendRequest($body, 'id_check');
    }
}

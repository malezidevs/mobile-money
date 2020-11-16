<?php

namespace DervisGroup\Pesa\Mpesa\Library;

use Carbon\Carbon;
use DervisGroup\Pesa\Database\Entities\MpesaStkRequest;
use DervisGroup\Pesa\Exceptions\MpesaException;
use DervisGroup\Pesa\Repositories\Generator;
use DervisGroup\Pesa\Repositories\Mpesa;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;

/**
 * Class StkPush
 * @package DervisGroup\Pesa\Mpesa\Library
 */
class StkPush extends ApiCore
{
    /**
     * @var string
     */
    protected $number;
    /**
     * @var int
     */
    protected $amount;
    /**
     * @var string
     */
    protected $reference;
    /**
     * @var string
     */
    protected $description;

    /**
     * @param string $amount
     * @return $this
     * @throws MpesaException
     */
    public function request($amount)
    {
        if (!\is_numeric($amount)) {
            throw new MpesaException('The amount must be numeric, got ' . $amount);
        }
        $this->amount = $amount;
        return $this;
    }

    /**
     * @param string $number
     * @return $this
     */
    public function from($number): self
    {
        $this->number = $this->formatPhoneNumber($number);
        return $this;
    }

    /**
     * Set the mpesa reference
     *
     * @param  string $reference
     * @param  string $description
     * @return $this
     * @throws MpesaException
     */
    public function usingReference($reference, $description): self
    {
        \preg_match('/[^A-Za-z0-9]/', $reference, $matches);
        if (\count($matches)) {
            throw new MpesaException('Reference should be alphanumeric.');
        }
        $this->reference = $reference;
        $this->description = $description;
        return $this;
    }

    /**
     * Send a payment request
     *
     * @param  null|int $amount
     * @param  null|string $number
     * @param  null|string $reference
     * @param  null|string $description
     * @return mixed
     * @throws \DervisGroup\Pesa\Exceptions\MpesaException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function push($amount = null, $number = null, $reference = null, $description = null)
    {
        $time = Carbon::now()->format('YmdHis');
        $shortCode = \config('pesa.c2b.short_code');
        if (config('pesa.sandbox')) {
            $shortCode = \config('pesa.c2b.till_number');
        }
        $passkey = \config('pesa.c2b.passkey');
        $callback = \config('pesa.c2b.stk_callback');
        $password = \base64_encode($shortCode . $passkey . $time);
        $good_phone = $this->formatPhoneNumber($number ?: $this->number);
        $body = [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $time,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount ?: $this->amount,
            'PartyA' => $good_phone,
            'PartyB' => $shortCode,
            'PhoneNumber' => $good_phone,
            'CallBackURL' => $callback,
            'AccountReference' => $reference ?? $this->reference ?? $good_phone,
            'TransactionDesc' => $description ?? $this->description ?? Generator::generateTransactionNumber(),
        ];
        $response = $this->sendRequest($body, 'stk_push');
        return $this->saveStkRequest($body, (array)$response);
    }

    /**
     * @param array $body
     * @param array $response
     * @return MpesaStkRequest|\Illuminate\Database\Eloquent\Model
     * @throws MpesaException
     */
    private function saveStkRequest($body, $response)
    {
        if ($response['ResponseCode'] == 0) {
            $incoming = [
                'phone' => $body['PartyA'],
                'amount' => $body['Amount'],
                'reference' => $body['AccountReference'],
                'description' => $body['TransactionDesc'],
                'CheckoutRequestID' => $response['CheckoutRequestID'],
                'MerchantRequestID' => $response['MerchantRequestID'],
                'user_id' => @(Auth::id() ?: request('user_id')),
            ];
            return MpesaStkRequest::create($incoming);
        }
        throw new MpesaException($response->ResponseDescription);
    }

    /**
     * Validate an initialized transaction.
     *
     * @param string|int $checkoutRequestID
     *
     * @return mixed
     * @throws MpesaException
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function validate($checkoutRequestID)
    {
        if ((int)$checkoutRequestID) {
            $checkoutRequestID = MpesaStkRequest::find($checkoutRequestID)->CheckoutRequestID;
        }
        $time = Carbon::now()->format('YmdHis');
        $shortCode = \config('pesa.c2b.short_code');
        $passkey = \config('pesa.c2b.passkey');
        $password = \base64_encode($shortCode . $passkey . $time);
        $body = [
            'BusinessShortCode' => $shortCode,
            'Password' => $password,
            'Timestamp' => $time,
            'CheckoutRequestID' => $checkoutRequestID,
        ];
        try {
            return $this->sendRequest($body, 'stk_status', true);
        } catch (RequestException $exception) {
            throw new MpesaException($exception->getMessage());
        }
    }
}

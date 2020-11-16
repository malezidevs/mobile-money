<?php

namespace DervisGroup\Pesa\Events;

use DervisGroup\Pesa\Database\Entities\MpesaBulkPaymentResponse;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class B2cPaymentFailedEvent
 * @package DervisGroup\Pesa\Events
 */
class B2cPaymentFailedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var MpesaBulkPaymentResponse
     */
    public $bulkPaymentResponse;
    /**
     * @var array
     */
    public $response;

    /**
     * B2cPaymentSuccessEvent constructor.
     * @param MpesaBulkPaymentResponse $mpesaBulkPaymentResponse
     * @param array $response
     */
    public function __construct(MpesaBulkPaymentResponse $mpesaBulkPaymentResponse, $response)
    {
        $this->bulkPaymentResponse = $mpesaBulkPaymentResponse;
        $this->response = $response;
    }
}

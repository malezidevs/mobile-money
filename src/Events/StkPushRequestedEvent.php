<?php

namespace DervisGroup\Pesa\Events;

use DervisGroup\Pesa\Database\Entities\MpesaStkRequest;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class StkPushRequestedEvent
 * @package DervisGroup\Pesa\Mpesa\Events
 */
class StkPushRequestedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var MpesaStkRequest
     */
    public $stk;

    /**
     * StkPushRequestedEvent constructor.
     * @param MpesaStkRequest $mpesaStkRequest
     */
    public function __construct(MpesaStkRequest $mpesaStkRequest)
    {
        $this->stk = $mpesaStkRequest;
    }
}

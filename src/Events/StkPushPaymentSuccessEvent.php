<?php

namespace DervisGroup\Pesa\Events;

use DervisGroup\Pesa\Database\Entities\MpesaStkCallback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class StkPushPaymentSuccessEvent
 * @package DervisGroup\Pesa\Events
 */
class StkPushPaymentSuccessEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var MpesaStkCallback
     */
    public $stk_callback;

    /**
     * StkPushPaymentSuccessEvent constructor.
     * @param MpesaStkCallback $stkCallback
     */
    public function __construct(MpesaStkCallback $stkCallback)
    {
        $this->stk_callback = $stkCallback;
    }
}

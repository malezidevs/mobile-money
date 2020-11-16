<?php

namespace DervisGroup\Pesa\Events;

use DervisGroup\Pesa\Database\Entities\MpesaC2bCallback;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Class C2BConfirmationEvent
 * @package DervisGroup\Pesa\Mpesa\Events
 */
class C2bConfirmationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var MpesaC2bCallback
     */
    public $transaction;

    /**
     * C2BConfirmationEvent constructor.
     * @param MpesaC2bCallback $c2bCallback
     */
    public function __construct(MpesaC2bCallback $c2bCallback)
    {
        $this->transaction = $c2bCallback;
    }
}

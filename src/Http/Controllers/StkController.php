<?php

namespace DervisGroup\Pesa\Http\Controllers;

use DervisGroup\Pesa\Events\StkPushRequestedEvent;
use DervisGroup\Pesa\Mpesa\Facades\STK;
use Illuminate\Http\Request;

/**
 * Class StkController
 * @package DervisGroup\Pesa\Http\Controllers
 */
class StkController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function initiatePush()
    {
        try {
            $stk = STK::request(request('amount'))
                ->from(request('phone'))
                ->usingReference(request('reference'), request('description'))
                ->push();
            event(new StkPushRequestedEvent($stk));
        } catch (\Exception $exception) {
            $stk = ['ResponseCode' => 900, 'ResponseDescription' => 'Invalid request', 'extra' => $exception->getMessage()];
        }
        return response()->json($stk);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function stkStatus($id)
    {
        return response()->json(STK::validate($id));
    }
}

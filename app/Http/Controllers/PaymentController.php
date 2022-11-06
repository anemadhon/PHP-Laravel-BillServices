<?php

namespace App\Http\Controllers;

use App\Http\Requests\TokenRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;

class PaymentController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Bill $payment, TokenRequest $token)
    {
        try {
            $payment->update([
                'status' => 'paid',
                'paid_date' => date('Y-m-d H:i:s')
            ]);

            return BillResource::make($payment->load(['category:id,name', 'user:id,name']));
        } catch (\Throwable $th) {
            $message = $th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage();
            $code = (int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode();

            return response()->json(['error' => $message], $code);
        }
    }
}

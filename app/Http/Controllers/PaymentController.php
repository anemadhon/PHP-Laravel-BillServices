<?php

namespace App\Http\Controllers;

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
    public function __invoke(Bill $payment)
    {
        try {
            $payment->update([
                'status' => 'paid',
                'paid_date' => date('Y-m-d H:i:s')
            ]);

            return BillResource::make($payment->load(['category:id,name', 'user:id,name']));
        } catch (\Throwable $th) {
            $message = $th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage();
            $code = $th->getCode() > 500 || $th->getCode() < 200 ? 500 : $th->getCode();

            return response()->json(['error' => $message], $code);
        }
    }
}

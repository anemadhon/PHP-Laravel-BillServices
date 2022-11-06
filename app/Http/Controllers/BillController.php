<?php

namespace App\Http\Controllers;

use App\Http\Requests\BillRequest;
use App\Http\Resources\BillResource;
use App\Models\Bill;
use App\Services\BillingServices;

class BillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $myBills = Bill::with(['category:id,name', 'user:id,name'])->paginate(10);

            return BillResource::collection($myBills);
        } catch (\Throwable $th) {
            $message = $th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage();
            $code = (int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode();

            return response()->json(['error' => $message], $code);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillRequest $request, BillingServices $billing)
    {
        try {
            $myBill = $billing->create($request->validated());

            return response()->json(['data' => [
                'id' => $myBill['id'],
                'status' => $myBill['status'],
                'amount_to_pay' => $myBill['amount_to_pay'],
                'link_to_pay' => route('payments.update', ['payment' => $myBill['id']])
            ]], 201);
        } catch (\Throwable $th) {
            $message = $th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage();
            $code = (int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode();

            return response()->json(['error' => $message], $code);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bill  $bill
     * @return \Illuminate\Http\Response
     */
    public function show(Bill $bill)
    {
        try {
            $myBill = $bill->load(['category:id,name', 'user:id,name']);

            return BillResource::make($myBill);
        } catch (\Throwable $th) {
            $message = $th->getCode() > 500 || $th->getCode() < 200 ? 'Internal Error' : $th->getMessage();
            $code = (int) $th->getCode() > 500 || (int) $th->getCode() < 200 ? 500 : (int) $th->getCode();

            return response()->json(['error' => $th->getMessage()], $code);
        }
    }
}

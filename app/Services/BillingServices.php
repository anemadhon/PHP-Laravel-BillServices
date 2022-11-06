<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Category;
use App\Models\UserLogin;
use Illuminate\Support\Str;

class BillingServices
{
    public function filterBillsUserId(array $payload)
    {
        $userLoggedIn = UserLogin::with('user')->find($payload['token']);

        return Bill::with(['category:id,name', 'user:id,name'])->where('user_id', $userLoggedIn->user->id)->paginate(10);
    }

    public function create(array $payload)
    {
        $otherCostOrTax = $this->getOtherCostFromSelectedCategory($payload['category_id']);
        $amount = $this->setAmountToPay($payload + ['tax_or_other_cost' => $otherCostOrTax]);
        $bill = Bill::create($payload + [
            'id' => 'bill' . Str::random(6),
            'status' => 'unpaid',
            'tax_or_other_cost' => $otherCostOrTax,
            'discount' => $amount['discount']
        ]);

        if (!$bill) {
            throw new Exception('Internal Error');
        }

        return [
            'id' => $bill->id,
            'status' => $bill->status,
            'amount_to_pay' => $amount['amount_to_pay'],
        ];
    }

    public function filterBillUserId(array $payload, Bill $bill)
    {
        $userLoggedIn = UserLogin::with('user')->find($payload['token']);

        return $bill->load(['category:id,name', 'user' => function ($query) use ($userLoggedIn)
        {
            return $query->find($userLoggedIn->user->id);
        }]);
    }

    private function getOtherCostFromSelectedCategory(string $id)
    {
        return Category::find($id)->cost;
    }

    private function setAmountToPay(array $attributes)
    {
        $discount = isset($attributes['discount']) && !empty($attributes['discount']) ? $attributes['discount'] : 0;

        return [
            'amount_to_pay' => $attributes['amount'] + $attributes['tax_or_other_cost'] - $discount,
            'discount' => $discount
        ];
    }
}

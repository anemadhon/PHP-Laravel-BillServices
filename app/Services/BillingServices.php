<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Category;
use Illuminate\Support\Str;

class BillingServices
{
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

        return [
            'id' => $bill->id,
            'status' => $bill->status,
            'amount_to_pay' => $amount['amount_to_pay'],
        ];
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

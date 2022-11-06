<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Category;

class BillingService
{
    public function create(array $payload)
    {
        $otherCostOrTax = $this->getOtherCostFromSelectedCategory($payload['category_id']);
        $amount = $this->setAmountToPay($payload + ['other_cost_or_tax' => $otherCostOrTax]);
        $bill = Bill::create($payload + [
            'status' => 'unpaid',
            'other_cost_or_tax' => $otherCostOrTax,
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
            'amount_to_pay' => $attributes['amount'] + $attributes['other_cost_or_tax'] - $discount,
            'discount' => $discount
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'category' => $this->category->name,
            'status' => $this->status,
            'owner' => $this->user->name,
            'amount' => $this->amount,
            'tax_or_other_cost' => $this->tax_or_other_cost,
            'discount' => $this->when($this->discount > 0, $this->discount),
            'amount_paid' => '',
            'due_date' => $this->due_date,
            'paid_date' => $this->paid_date,
            'created_at' => $this->created_at,
        ];
    }
}

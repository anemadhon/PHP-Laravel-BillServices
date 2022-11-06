<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'string', 'exists:users,id'],
            'category_id' => ['required', 'string', 'exists:categories,id'],
            'name' => ['required', 'string', 'min:5', 'max:50'],
            'amount' => ['required'],
            'due_date' => ['required', 'date_format:Y-m-d', 'after_or_equal:tomorrow'],
            'discount' => ['nullable']
        ];
    }
}

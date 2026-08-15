<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $orderId = optional($this->route('order'))->id;

        // 1) The base rules: required, string, max:255
        $rules = [
            'order_name' => [
                'required',
                'string',
                'max:255',
            ],
        ];

        if ($orderId) {
            // Update scenario: exclude this record's ID from the unique check
            $rules['order_name'][] = 'unique:orders,order_name,'.$orderId;
        } else {
            // Store scenario: no ID to exclude, so standard unique rule
            $rules['order_name'][] = 'unique:orders,order_name';
        }

        return $rules;
    }
}

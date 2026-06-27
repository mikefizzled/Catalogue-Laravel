<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenusRequest extends FormRequest
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
        $genusId = optional($this->route('genus'))->id;

        return [
            'genus_name' => [
                'required',
                'string',
                'max:255',
                'unique:genera,genus_name,'.$genusId.',id', // Ensure genus_name is unique except when updating
            ],
            'family_id' => [
                'required',
                'exists:families,id',
            ],
        ];
    }
}

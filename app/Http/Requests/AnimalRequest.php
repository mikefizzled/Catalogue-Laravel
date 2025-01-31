<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
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
        $rules = [
            'common_name' => [
                'required',
                'string',
                'max:255'
            ],
            'scientific_name' => [
                'required',
                'string',
                'max:255',
                'unique:animals,scientific_name'
            ],
            'genus_id' => [
                'required',
                'exists:genera,id'
            ],
            'thumbnail' => [
                'required',
                'image',
                'mimes:jpg, webp',
                'max:512'
            ],
            
        
        ];
        return $rules;
    }
}

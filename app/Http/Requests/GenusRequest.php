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

        $rules = [
            'genus_name' => [
                'required',
                'string',
                'max:255',
            ],
            'family_id' => [
                'required',
                'exists:families,id'
            ]
        ];

        if ($genusId) {
            // Update scenario: exclude this record's ID from the unique check
            $rules['genus_name'][] = 'unique:genera,genus_name,' . $genusId;
        } else {
            // Store scenario: no ID to exclude, so standard unique rule
            $rules['genus_name'][] = 'unique:genera,genus_name';
        }

        return $rules;
    }
}

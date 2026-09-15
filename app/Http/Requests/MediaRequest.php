<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MediaRequest extends FormRequest
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

        return [
            'animal_id' => ['required', 'exists:animals,id'],
            'location_id' => ['required', 'exists:locations,id'],

            'gender' => ['nullable', 'in:male,female,unknown'],
            'age' => ['nullable', 'in:juvenile,adult,unknown'],

            'caption' => ['nullable', 'string', 'max:1000'],
            'hash' => ['nullable', 'string', 'max:255'],

            'meta_keys' => ['nullable', 'array'],
            'meta_keys.*' => ['nullable', 'string', 'max:255'],

            'meta_values' => ['nullable', 'array'],
            'meta_values.*' => ['nullable', 'string', 'max:1000'],
        ];
    }
}

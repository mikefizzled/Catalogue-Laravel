<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'city' => [
                'required',
                'string',
                'max:255',
            ],
            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],
            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],
            'area_caption' => [
                'nullable',
                'string',
                'max:500',
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,webp',
            ],
        ];

        $locationId = optional($this->route('location'))->id;

        if ($locationId) {
            $rules['name'][] = 'unique:locations,name,'.$locationId;
        } else {
            $rules['name'][] = 'unique:locations,name';
        }

        return $rules;
    }
}

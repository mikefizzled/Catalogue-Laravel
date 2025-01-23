<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyRequest extends FormRequest
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
            'family_name' => [
                'required',
                'string',
                'max:255'
            ],
            'common_name' => [
                'required',
                'string',
                'max:255'
            ],
            'order_id' => [
                'required',
                'exists:orders,id'
            ]];
        
        $familyId = optional($this->route('family'))->id;
        // Performing the unique check against with or without checking against itself
        if($familyId)
            $rules['family_name'][] = 'unique:families,family_name,'.$familyId;
        else
            $rules['family_name'][] = 'unique:families,family_name';

        return $rules;
    }
}

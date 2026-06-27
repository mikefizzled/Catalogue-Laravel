<?php

namespace App\Http\Requests;

use App\Models\ConservationList;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnimalUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $conservationLists = ConservationList::all();

        // Retrieve the animal being updated from the route.
        $animalId = optional($this->route('animal'))->id;

        $rules = [
            'common_name' => ['required', 'string', 'max:255'],
            'scientific_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('animals')->ignore($animalId),
            ],
            'genus_id' => ['required', 'exists:genera,id'],
            'thumbnail' => ['sometimes', 'nullable', 'image', 'mimes:jpg,webp', 'max:512'],
            'statuses' => ['required', 'array'],
        ];

        foreach ($conservationLists as $conservationList) {
            $rules["statuses.{$conservationList->id}"] = 'required|in:green,amber,red,former breeder,not assessed';
        }

        return $rules;
    }
}

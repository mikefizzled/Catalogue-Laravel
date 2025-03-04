<?php

namespace App\Http\Requests;

use App\Models\ConservationList;
use Illuminate\Foundation\Http\FormRequest;

class AnimalCreateRequest extends FormRequest
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
        
        $rules = [
            'common_name'       => ['required', 'string', 'max:255'],
            'scientific_name'   => ['required', 'string', 'max:255', 'unique:animals,scientific_name'],
            'ebird_species_code'=> ['required', 'string', 'max:255'],
            'genus_id'          => ['required', 'exists:genera,id'],
            'thumbnail'         => ['required', 'image', 'mimes:jpg,webp', 'max:512'],
            'statuses'          => ['required', 'array'],
        ];

        // Ensure each conservation list has a status.
        foreach ($conservationLists as $conservationList) {
            $rules["statuses.{$conservationList->id}"] = 'required|in:green,amber,red,former breeder,not assessed';
        }

        return $rules;
    }
}

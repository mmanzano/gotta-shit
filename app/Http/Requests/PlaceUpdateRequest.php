<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->route('place')->is_author;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'geo_lat' => 'required|numeric|between:-90,90|distinct_place_update',
            'geo_lng' => 'required_with:geo_lat|numeric|between:-180,180',
            'stars' => 'required|numeric|between:0,5',
        ];
    }
}

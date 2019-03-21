<?php

namespace GottaShit\Http\Requests;

use GottaShit\Entities\Place;
use Illuminate\Foundation\Http\FormRequest;

class PlaceDestroyRequest extends FormRequest
{
    public $place;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->place = Place::withTrashed()->findOrFail(request()->route('place'));

        return $this->place->isAuthor;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}

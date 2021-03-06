<?php

namespace App\Http\Requests;

use App\Entities\Place;
use Illuminate\Foundation\Http\FormRequest;

class PlaceShowRequest extends FormRequest
{
    /** @var Place $place */
    public $place;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $this->place = Place::withTrashed()->findOrFail(request()->route('place'));

        if ($this->place->trashed() && !$this->place->is_author) {
            return false;
        }

        return true;
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

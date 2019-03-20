<?php

namespace GottaShit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $placeId = request()->route('place')->id;

        $commentPlaceId = request()->route('comment')->place_id;

        $commentAuthorId = request()->route('comment')->user_id;

        return  ($placeId == $commentPlaceId) && (Auth::id() == $commentAuthorId);
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

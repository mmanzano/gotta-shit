<?php

namespace GottaShit\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return request()->route('place')->isAuthor || request()->route('comment')->isAuthor;
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

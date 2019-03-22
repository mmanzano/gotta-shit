<?php

namespace GottaShit\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::id() == request()->route('user')->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|max:255',
            'username' => [
                'required',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore(Auth::id()),
            ],
            'password' => 'nullable|confirmed|min:6',
        ];
    }
}

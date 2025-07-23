<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestChangePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password'              => 'required|string|confirmed|min:8',
            'password_confirmation' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'password.required'              => 'Dữ liệu không được để trống',
            'password_confirmation.required' => 'Dữ liệu không được để trống',
            'password.confirmed'             => 'Mật khẩu không khớp',
            'password.min'                   => 'Mật khẩu phải có ít nhất 8 ký tự',
        ];
    }
}

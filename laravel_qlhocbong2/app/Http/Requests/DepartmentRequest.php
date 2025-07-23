<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
            'd_name' => 'required|unique:departments,d_name,' . $this->id,
            'd_code' => 'required|unique:departments,d_code,' . $this->id,

        ];
    }

    public function messages()
    {
        return [
            'd_name.required' => 'Dữ liệu không được để trống',
            'd_name.unique'   => 'Dữ liệu đã tồn tại',
            'd_code.required' => 'Dữ liệu không được để trống',
            'd_code.unique'   => 'Dữ liệu đã tồn tại',
        ];
    }
}

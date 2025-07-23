<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeScholarshipRequest extends FormRequest
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
            'ts_name' => 'required|unique:type_scholarship,ts_name,'. $this->id
        ];
    }

    public function messages()
    {
        return [
            'ts_name.required' => 'Dữ liệu không được để trống',
            'ts_name.unique'   => 'Dữ liệu đã tồn tại'
        ];
    }
}

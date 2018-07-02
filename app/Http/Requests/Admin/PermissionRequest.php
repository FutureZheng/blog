<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'name' => 'bail|required|alpha_dash',
            'description' => 'bail|required',
            'url' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute为必填项',
            'alpha_dash' => ':attribute仅包含字母、数字、破折号（ - ）以及下划线（ _ ）',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '权限名',
            'description' => '权限描述信息',
            'url' => '权限url信息'
        ];
    }
}

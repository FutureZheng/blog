<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'username' => 'bail|required',
            'email' => 'bail|required|email',
            'password' => 'required|between:6,20|confirmed'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute为必填项',
            'email' => ':attribute格式不合法',
            'between' => ':attribute长度必须为:min到:max',
            'confirmed' => '两次输入的密码不一致',
        ];
    }

    public function attributes()
    {
        return [
            'username' => '用户名',
            'email' => '邮箱',
            'password' => '密码'
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * 定义验证的规则
     * @return array
     */
    public function rules(){
        return [
            'cid' => 'bail|required|integer',
            'tags' => 'sometimes|array',
            'title' => 'bail|required',
            'author' => 'bail|required',
            'description' => 'bail|required',
            'is_recommend' => 'bail|required|integer',
            'content' => 'required',
        ];      //自定义验证的规则
    }

    /**
     * 这边定义语言文件的
     */
    public function attributes(){
        return [
            'cid' => '文章所属分类',
            'tags' => '文章标签',
            'title' => '文章的标题',
            'author' => '文章的作者',
            'description' => '文章的描述信息',
            'content' => '文章的内容',
            'is_recommend' => '是否为博主推荐'
        ];
    }

    /**
     * 自定义错误消息
     */
    public function messages(){
        return [
            'required' => ':attribute为必填项',
            'integer'  => ':attribute为整型',
            'array'  => ':attribute必须为数组',
        ];
    }
}

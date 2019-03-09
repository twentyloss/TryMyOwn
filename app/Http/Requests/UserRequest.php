<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
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
            'name'=>'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,'.Auth::id(),
            'email'=>'required|email',
            'introduction'=>'max:80',
            'avatar'=>'mimes:bmp,jpeg,gif,png|dimensions:min_width=208,min_height=208',
        ];
    }

    public function messages()
    {
        return ['name.required'=>'用户名不能为空😡',
            'name.between'=>'用户名限制在3~25字符内',
            'name.regex'=>'非法字符😡',
            'name.unique'=>'该用户名已被使用',
            'avatar.mime'=>'请上传可用的格式文件',
            'avatar.dimensions'=>'图片分辨率不够哦/(ㄒoㄒ)/~~',
        ];
    }
}

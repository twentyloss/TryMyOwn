<?php

namespace App\Http\Requests;

class ReplyRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':

            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                  'content'=>'required|max:80'
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'content.required'=>'不能提交空回复哦😡',
            'content.max'=>'废话太多啦！',
        ];
    }
}

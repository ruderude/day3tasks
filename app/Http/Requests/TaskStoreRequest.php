<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'max:5',
        ];
    }

    /**
     * エラーメッセージを日本語化
     * 
     */
    public function messages() {
        return [
            'title.max' => 'タスクタイトルは500文字以内で入力してください',
        ];
    }
}

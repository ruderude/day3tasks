<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class TaskStoreRequest extends FormRequest
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
            'forms.title' => 'max:500',
        ];
    }

    /**
     * エラーメッセージを日本語化
     *
     */
    public function messages() {
        return [
            'forms.title.max' => 'タスクタイトルは500文字以内で入力してください',
        ];
    }

    /**
     * [override] バリデーション失敗時ハンドリング
     *
     * @param Validator $validator
     * @throw HttpResponseException
     * @see FormRequest::failedValidation()
     */
    protected function failedValidation(Validator $validator) {
        $response['status']  = 400;
        $response['statusText'] = 'バリデーション失敗';
        $response['errors']  = $validator->errors();
        throw new HttpResponseException(
            response()->json( $response)
        );
    }
}

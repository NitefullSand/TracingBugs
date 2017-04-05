<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrgRequest extends FormRequest
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
     * 规则：name字段不能为空，长度小于255
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required | max:255',
        ];
    }
}

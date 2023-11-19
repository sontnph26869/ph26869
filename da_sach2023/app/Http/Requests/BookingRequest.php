<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [];
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()) {
            case 'POST':
                switch ($currentAction) {
                    case 'index':
                        $rules = [
                            'name' => 'required',
                            'email' => 'required|email',
                            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
                            'address' => 'required',
                        ];

                        break;
                }
                break;
            default:
                break;
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không hợp lệ. ',
            'phone.min' => 'Số điện thoại cần 10 ký tự.',
            'phone.max' => 'Số điện thoại chỉ tối đa 10 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ của bạn.',
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\GreaterThanField;

class VoucherRequest extends FormRequest
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
                case 'store':
                    $rules = [
                        'code' => 'required|unique:vouchers|min:6|max:15',
                        'type' => 'required',
                        'value' => 'required|integer',
                        'quantity' => 'required|integer|numeric|min:0',
                        'start_date' => 'required|date|after_or_equal:today',
                        'end_date' => 'required|date|after:start_date',
                    ];

                    // Kiểm tra nếu cả hai trường min_order_amount và max_order_amount đều được cung cấp
                    if ($this->input('min_order_amount') !== null && $this->input('max_order_amount') !== null) {
                        $rules['min_order_amount'] = 'numeric';
                        $rules['max_order_amount'] = ['numeric', new GreaterThanField('min_order_amount')];
                    }
                    if ($this->type == 1) {
                        // Kiểm tra nếu type là 1, giá trị value không được vượt quá 100
                        $rules['value'] = 'required|integer|max:100';
                    }

                    break;
                case 'update':
                    $rules = [
                        'code' => ['required', Rule::unique('vouchers')->ignore($this->id), 'min:6', 'max:15'],
                        'type' => 'required',
                        'value' => 'required|integer',
                        'quantity' => 'required|integer|numeric|min:0',
                        'start_date' => 'required|date|after_or_equal:today',
                        'end_date' => 'required|date|after:start_date',
                    ];

                    if ($this->input('min_order_amount') !== null && $this->input('max_order_amount') !== null) {
                        $rules['min_order_amount'] = 'numeric';
                        $rules['max_order_amount'] = ['numeric', new GreaterThanField('min_order_amount')];
                    }
                    if ($this->type == 1) {
                        // Kiểm tra nếu type là 1, giá trị value không được vượt quá 100
                        $rules['value'] = 'required|integer|max:100';
                    }
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
            'code.required' => 'Vui lòng nhập tên mã giảm giá.',
            'code.unique' => 'Mã giảm đã tồn tại. Vui lòng nhập mã khác.',
            'code.min' => 'Mã giảm giá tối thiểu từ 6 ký tự.',
            'code.max' => 'Mã giảm giá tối đa 15 ký tự.',
            'type.required' => 'Vui lòng nhập loại mã giảm giá.',
            'value.required' => 'Vui lòng nhập giá trị mã giảm giá.',
            'value.integer' => 'Giá trị giảm giá phải là số nguyên.',
            'value.max' => 'Mã giảm giá tối đa là 100%.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.integer' => 'Số lượng mã giảm giá phải là số nguyên.',
            'quantity.min' => 'Số lượng không được nhỏ hơn 0.',

            'min_order_amount.numeric' => 'Giá trị tối thiểu phải là số.',
            'max_order_amount.numeric' => 'Giá trị tối đa phải là số.',
            'max_order_amount.greater_than_field' => 'Giá trị tối đa phải lớn hơn giá trị tối thiểu.',
            'start_date.required' => 'Vui lòng nhập ngày và giờ bắt đầu.',
            'end_date.required' => 'Vui lòng nhập ngày và giờ hết hạn.',
            'start_date.after_or_equal' => 'Ngày và giờ bắt đầu phải sau hoặc bằng ngày hiện tại.',
            'end_date.after' => 'Ngày và giờ hết hạn phải sau ngày bắt đầu.',
        ];
    }
}

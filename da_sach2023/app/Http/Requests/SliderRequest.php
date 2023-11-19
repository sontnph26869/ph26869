<?php

namespace App\Http\Requests;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\Slider\SliderController;
use App\Models\Slider;

class SliderRequest extends FormRequest
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
        $slider = Slider::find($this->route('id'));
        $table = (new Slider())->getTable();
        $currentAction = $this->route()->getActionMethod();
        switch ($this->method()) {
            case 'POST':
            case 'PUT':
                switch ($currentAction) {
                    case 'store':
                        $rules = [
                           
                            'alt_text' => 'required|unique:' . $table,
                            'status' => 'required',
                        ];
                        break;
                    case 'update':
                        $rules = [
                            'alt_text' => 'required|' . Rule::unique('sliders')->ignore($slider->id),
                            'status' => 'required',
                        ];
                        break;
                }
            default:
                break;
        }
        return $rules;
    }
    public function messages()
    {
        return [
           
            'alt_text.required' => 'Mô tả không được bỏ trống',
            'alt_text.unique' => ' Không được trùng mô tả',
            'status.required' => 'Trạng thái không được bỏ trống',

        ];
    }
}

<?php

namespace App\Http\Requests;

use App\Rules\UniqueSlug;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostTypeRequest extends FormRequest
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
                    case 'update' :
                    case 'store' :
                        $rules = [
                            'name' => 'required',
                            'status' => 'required',
                            'slug' => 'unique:post_types'

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
            'name.required' => 'Vui lòng nhập tên danh mục',
            'status.required' => 'Vui lòng chọn trạng thái danh mục.',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng nhập slug khác.'
        ];
    }
}

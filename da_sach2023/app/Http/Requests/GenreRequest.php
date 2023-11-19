<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
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
                            'slug' => 'unique:genres'
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
            'name.required' => 'Vui lòng nhập tên thể loại',
            'status.required' => 'Vui lòng nhập trạng thái',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng nhập slug khác.'
        ];
    }
}

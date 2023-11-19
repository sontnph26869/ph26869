<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
        $add = [];
        $edit = [];

        $check = $this->route()->getActionMethod();
        switch ($this->method()):
            case 'POST':
                switch ($check):
                    case 'store':
                        $add = [
                            'name' => 'required|unique:permissions',
                            'display_name' => 'required',
                            'group' => 'required',
                        ];
                        break;
                    case 'update':
                        $edit = [
                            'name' => 'required',
                            'display_name' => 'required',
                            'group' => 'required',
                        ];
                        break;
                endswitch;
                break;
        endswitch;
        return $check === 'store' ? $add : $edit;
    }
    public function messages()
    {
        return [
            'name.required' => 'Tên quyền không được để trống!',
            'display_name.required' => 'Tên hiển thị không được để trống!',
            'group.required' => 'Nhóm không được để trống!',
            'name.unique' => 'Tên quyền đã tồn tại!'
        ];
    }
}

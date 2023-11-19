<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;


class LoginRequest extends FormRequest
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
    $check = $this->route()->getActionMethod();

    switch ($this->method()) {
        case 'POST':
        case 'GET':
            switch ($check) {
                case 'store':
                    return [
                        'name' => 'required',
                        'email' => 'required|unique:users',
                        'password' => 'required',
                        'status' => 'required'
                    ];
                case 'update':
                     // Assuming you're using a route model binding
                    $user = User::find($this->route('id'));
                    return [
                        'name' => 'required',
                        'email' => [
                            'required',
                            Rule::unique('users')->ignore($user->id),
                        ],
                        'status' => 'required'
                    ];
            }
            break;
    }
    return [];
}

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'password.required' => 'Mật khẩu không được để trống!',
            'email.unique' => 'Email đã tồn tại!',
            'status.required' => 'Trạng thái không được để trống!'
        ];
    }
}

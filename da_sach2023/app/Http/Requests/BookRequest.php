<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
                        $rules = [
                            'name' => 'required',
                            'language' => 'required|string',
                            'status' => 'required',
                            'start_date' => 'required',
                            'genre_id' => 'required',
                            'slug' => 'unique:books',

                        ];
                        break;
                    case 'store' :
                        $rules = [
                            'name' => 'required',
                            'language' => 'required|string',
                            'status' => 'required',
                            'poster' => 'required',
                            'genre_id' => 'required',
                            'slug' => 'unique:books',
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
            'name.required' => 'Vui lòng nhập tên',
            'slug.unique' => 'Slug đã tồn tại. Vui lòng nhập slug khác.',
            'language.required' => 'Vui lòng nhập ngôn ngữ',
            'status.required' => 'Vui lòng nhập trạng thái',
            'poster.required' => 'Vui lòng nhập poster',
            'genre_id.required' => 'Vui lòng nhập thể loại phim',
        ];
    }
}

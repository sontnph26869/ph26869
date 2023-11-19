<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;

class StorePostRequest extends FormRequest
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
        $table=(new Post())->getTable();

        return [
            //
            'title'=>'required|unique:'.$table,
          

            'content'=>'required',


            'image'=>'required',

            'status'=>'required',
        ];
    }
    public function messages(){
        return [
            'title.required'=>'Tên không được bỏ trống!',
            'title.unique'=>'Tên không được trùng!',
            'content.required'=>'Nội dung không được bỏ trống!',
            'image.required'=>'Ảnh không được bỏ trống!',
            'status.required'=>'Trạng thái không được bỏ trống!',
        ];
    }
}

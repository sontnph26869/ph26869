<?php

namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Post;

class UpdatePostRequest extends FormRequest
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
        $post = Post::find($this->route('id'));
        $table=(new Post())->getTable();
        return [
            'title' => 'required|unique:' . $table . ',title,' . $post->id,
            'slug' => 'required|unique:' . $table . ',slug,' . $post->id,
            'content' => 'required',
            'status' => 'required',
        ];
}
public function messages(){
    return [
        'title.required'=>'Tên không được bỏ trống!',
        'title.unique'=>'Tên  không được trùng!',
        'slug.required'=>'Đường dẫn không được bỏ trống!',
        'slug.unique'=>'Đường dẫn không được trùng!',
        'content.required'=>'Nội dung không được bỏ trống!',
        'status.required'=>'Trạng thái không được bỏ trống!',
    ];
}
}
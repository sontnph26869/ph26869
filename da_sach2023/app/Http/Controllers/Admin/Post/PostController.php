<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\PostType;
use App\Models\Post_Type_Post;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Post::query();
$postTypes = PostType::all();


        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }
        //lấy tất dữ liệu trong bảng post
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        if ($request->has('postTypes')) {
            $post_type = $request->input('postTypes');
        
            // Lấy ra bài viết có mối quan hệ với loại bài viết đã chọn
            if ($post_type != 0) {
                $postIds = Post_Type_Post::where('post_type', $post_type)->pluck('post_id')->all();
                $query->whereIn('id', $postIds);
            }
            // Lọc bài viết dựa trên danh sách các post_id đã lấy được
        }

        $data1 =$query->paginate(3);
        return view('admin.posts.index', compact('data1','postTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
     
        if (Auth::check()) {
            $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
            $data1 = PostType::all(); // Lấy dữ liệu trong bảng post_type
            return view('admin.posts.create', compact('user', 'data1'));
        } else {
            // Người dùng chưa đăng nhập, xử lý theo yêu cầu của bạn
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //lưu dữ liệu vào database
        try {
            $user = Auth::user(); 
            $model = new Post();
            //lấy tất cả dữ liệu trong data
            $model->fill($request->all());

            $model->user_id=$user->id;
       
            if ($request->hasFile('image')) {
                // Upload and store the image
                $uploadedImage = upload_file('postTypes', $request->file('image'));
                if ($uploadedImage) {
                    // Update the 'image' attribute with the correct file path
                    $model->image = $uploadedImage;
                }
            }
            if ($model->slug == null) {
                $model->slug = $model->title;
            }
            $model->save();
            // dd($request->post_type);

            if (empty($request->post_type)) {
                // Trường hợp khi mảng danh mục rỗng
                $post_type_posts = new Post_Type_Post();
                $post_type_posts->post_id = $model->id;
                // dd($post_type_posts->post_id);
                $post_type_posts->post_type ==null;
                
            } else {
                // Trường hợp khi mảng danh mục không rỗng
                foreach ($request->post_type as $post_type) {
                    $post_type_posts = new Post_Type_Post();
                    $post_type_posts->post_id = $model->id;
                    $post_type_posts->post_type = $post_type;
                    $post_type_posts->save();
                }
            }
            if ($model->save()) {
                toastr()->success('Thêm bài viết thành công!', 'success');
                return redirect()->route('post.index');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $id = $request->route('id');
        //in 1 bản ghi ra giao diện
        $model = User::query()->orderByDesc('id')->get();
        $data = Post::find($id);
        $post_type = PostType::all();
        $post_type_posts = Post_Type_Post::where('post_id', $id)->get();
        return view('admin.posts.show', compact('data', 'model', 'post_type', 'post_type_posts'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //lấy dữ liệu theo id 

        if (Auth::check()) {
            $user = Auth::user(); // Lấy thông tin người dùng đã đăng nhập
            $data = Post::find($id);
            if (!$data) {
                // Xử lý khi bản ghi không tồn tại
                return redirect()->route('post.index')->with('error', 'Bản ghi không tồn tại.');
            }
            $post_type = PostType::all();
            $post_type_posts = Post_Type_Post::where('post_id', $id)->get(); //lấy dữ liệu trong bảng post_type_posts theo post_id
           return view('admin.posts.edit', compact('data', 'user', 'post_type', 'post_type_posts'));
  
        } else {
            // Người dùng chưa đăng nhập, xử lý theo yêu cầu của bạn
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, $id)
    {
        //cập nhật dữ liệu trong bảng post
        try {
            $model = Post::find($id);
            $model->fill($request->all()); 

          // đoạn này là odel -
            $image_old=$request->image; //nhưng có model này lf lấy từ db //uk xog gán $image_old tao sợ nó có hai cái mdoel nó k hiểu
            // dd($image_old);
            if ($request->hasFile('image') && $request->file('image')) {
                // delete_file($image_old); 
                $deletetImg=Storage::delete($image_old);
                // $deleteImg=delete_file($image_old); 
                // if($deleteImg){
                    $model->image = upload_file('image', $request->file('image'));
                // }
            }
            $model->save();
            $postTypes = $request->input('post_type', []);    //lấy mảng dữ liệu ngoài giao diện 
            $model->postTypePosts()->delete();               //xóa dự liệu cũ trong bảng post_type_posts
            if (empty($request->post_type)) {
                // Trường hợp khi mảng danh mục rỗng
            } else {
                // Trường hợp khi mảng danh mục không rỗng
                foreach ($request->post_type as $post_type) {
                    $post_type_posts = new Post_Type_Post();
                    $post_type_posts->post_id = $model->id;
                    $post_type_posts->post_type = $post_type;
                    $post_type_posts->save();
                }
            }
            if ($model->save()) {
                toastr()->success('Sửa mới bài viết thành công!', 'success');
                return redirect()->route('post.index');
            }
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }
    //

   


    // 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //xóa dữ liệu 
        // dd($id);

        try {
            $data = Post::find($id);
            $data->delete();
            toastr()->success(' Xóa bài viết  thành công!', 'success');
            return redirect()->route('post.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }
    public function trash()
    {
        $trashedPosts = Post::onlyTrashed()->get();
        return view('admin.posts.trash', compact('trashedPosts'));
    }
    public function restore($id)
    {
        $post = Post::withTrashed()->find($id);
        $post->restore();
        toastr()->success(' Khôi phục bài viết  thành công!', 'success');
        return redirect()->route('post.trash');
    }
    public function forceDelete($id)
    {
        $post = Post::withTrashed()->find($id);
        $post->forceDelete();
        toastr()->success(' Xóa bài viết  thành công!', 'success');
        return redirect()->route('post.trash');
    }
    public function updateStatus(Request $request, $id) {
        $item = Post::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Post::whereIn('id', $ids)->delete();
            toastr()->success( 'Thành công xoá các bài viết đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy các bài viết đã chọn');
        }
    }


    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $model = Post::withTrashed()->whereIn('id', $ids);
            $model->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn bài viết');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các bài viết đã chọn');
        }
        return redirect()->route('post.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $model = Post::withTrashed()->whereIn('id', $ids);
            $model->restore();
            toastr()->success('Thành công', 'Thành công khôi phục bài viết');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các mã giảm giắ đã chọn');
        }
        return redirect()->route('post.trash');
    }
}

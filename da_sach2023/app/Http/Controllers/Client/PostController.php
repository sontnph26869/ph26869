<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Post_Type_Post;
use App\Models\User;
use App\Models\comment;
use App\Models\Replies;
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
        //
        $query = Post::query();
        $postTypes = PostType::all();
        // $comments = comment::all();

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
     
        $data1 = $query->orderBy('created_at', 'desc')->paginate(3);
        // $commentCount = $comments->count();
        return view('client.blogs.blog', compact('data1', 'postTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $user = Auth::user();
            $model = new comment();
            //lấy tất cả dữ liệu trong data
            $model->fill($request->all());
            $model->user_id = $user->id;
            // dd($model->user_id);
            $model->save();
            //gán dữ liệu vào bảng post_type_posts
            if ($model->save()) {
                toastr()->success('Thêm bình luận thành công!', 'success');
                return redirect()->back();
            }
        }
        catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }

    //rep cmt
    public function repStore(Request $request)
    {
        try {
            $user = Auth::user();
            $model = new Replies();
            $model->fill($request->all());
            $model->user_id = $user->id;
            $model->comment_id = $request->input('commentId');
            $model->parent_id = $request->input('parentId');
            // $model->parent_id = $request->input('parentId');
            // dd($model);
            $model->save(); // Save the model once
            toastr()->success('Thêm bình luận thành công!', 'success');
            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle the exception if needed
            // You can add specific error handling logic here if you encounter a known database error
            return redirect()->back()->withErrors(['error' => 'Lỗi khi lưu bình luận.']);
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
        //
        $id = $request->route('id');
        $data = Post::find($id);
    
        if ($data) {
            // Lấy danh mục của bài viết hiện tại
            $post_type_post = Post_Type_Post::where('post_id', $id)->first();
            // $comment_id=comment::where('post_id',$id)->first();
            // dd($comment_id);
            if ($post_type_post) {
                $post_type_id = $post_type_post->post_type;
                $post_type_one = PostType::find($post_type_id);
                // dd($post_type_one);
                // Lấy các bài viết liên quan cùng danh mục
                $related_posts = Post_Type_Post::where('post_type', $post_type_id)
                    ->where('post_id', '!=', $id) // Loại trừ bài viết hiện tại
                    ->get();
                // Lấy tên và hình ảnh từ bảng 'posts' cho các bài viết liên quan
                $related_posts->load('post'); // Sử dụng quan hệ để tải thông tin từ bảng 'posts'
            }
            else {
                // Handle the case when there is no category for the current post
                $post_type_id = null; // or any other default value you want
                $post_type_one = null;
                $related_posts = []; // or any other default value you want
            }
            // Lấy tất cả các danh mục (post types)
            $post_type = PostType::all();
            // dd($post_type);
            $post_type_posts = Post_Type_Post::where('post_id', $id)->get();
            $comment_id = comment::all();
            $reply_id = Replies::all();
            // dd($reply_id);

            $comments = $data->comments;
            if ($data) {
                // Tăng lượt xem của bài viết
                $data->view++;
                $data->save();
                $commentCount1 = $comments->count(); // Count the number of comments
                // dd($commentCount1);
                $replyCount = 0;
                // Calculate the total number of replies for each comment
                foreach ($comments as $comment) {
                    $replies = Replies::where('comment_id', $comment->id)->get();
                    // dd($replies);
                    $replyCount = $replies->count();
                }
                $commentCount = $commentCount1 + $replyCount;
                // dd($commentCount);
            }
            return view('client.blogs.blog-detail', compact('data', 'related_posts', 'post_type', 'post_type_posts', 'post_type_one', 'comments','comment_id','reply_id','commentCount'));
        }

    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //
    }
}
<?php

namespace App\Http\Controllers\Admin\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Replies;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $query = Replies::query();
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('post_id', 'like', '%' . $search . '%');
        }
        // $postTypes = comment::all();
        $replies = $query->orderBy('created_at', 'desc')->paginate(3);
        return view('admin.replies.index', compact('replies'));
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        try {
            $data = Replies::find($id);
            $data->delete();
            toastr()->success(' Xóa Bình Luận  thành công!', 'success');
            return redirect()->route('reply.index');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) { // Lỗi duplicate entry
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp.Vui lòng sửa đường dẫn']);
            }
        }
    }
    public function trash()
    {
        $trashedPosts = Replies::onlyTrashed()->get();
        return view('admin.replies.trash', compact('trashedPosts'));
    }
    public function restore($id)
    {
        $post = Replies::withTrashed()->find($id);
        $post->restore();
        toastr()->success(' Khôi phục Bình luận  thành công!', 'success');
        return redirect()->route('reply.trash');
    }
    public function forceDelete($id)
    {
        $post = Replies::withTrashed()->find($id);
        $post->forceDelete();
        toastr()->success(' Xóa Bình luận thành công!', 'success');
        return redirect()->route('reply.trash');
    }
    public function updateStatus(Request $request, $id) {
        $item = Replies::find($id);
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
            Replies::whereIn('id', $ids)->delete();
            toastr()->success( 'Thành công xoá các Bình luận đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy các Bình luận đã chọn');
        }
    }


    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $model = Replies::withTrashed()->whereIn('id', $ids);
            $model->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn bình luận');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các bình luận đã chọn');
        }
        return redirect()->route('reply.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $model = Replies::withTrashed()->whereIn('id', $ids);
            $model->restore();
            toastr()->success('Thành công', 'Thành công khôi phục bình luận');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các bình luận đã chọn');
        }
        return redirect()->route('reply.trash');
    }
}

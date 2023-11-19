<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostTypeRequest;
use App\Models\PostType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Kalnoy\Nestedset\NestedSet;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PostTypeRequest $request)
    {
        $query = PostType::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 1 || $status == 0) {
                $query->where('status', $status);
            } else if ($status == 'all') {
                $query->get();
            }
        }
        $postTypes = $query->orderBy('id', 'DESC')->paginate(5);
        return view('admin.post-type.index', compact('postTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $postTypes = PostType::all();
        return view('admin.post-type.add', compact('postTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostTypeRequest $request)
    {
        try {
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $request->image = uploadFile('postTypes', $request->file('image'));
            } else {
                $request->image = null;
            }
            if (!$request->slug) {
                $request->slug = Str::slug($request->name);
            } else {
                $request->slug = Str::slug($request->slug);
            }
            $postType = new PostType();
            $postType->name = $request->name;
            $postType->description = $request->description;
            $postType->status = $request->status;
            $postType->slug = $request->slug;
            $postType->image = $request->image;
            if ($request->parent_id && $request->parent_id !== 'none') {
                // Here we define the parent for new created category
                $node = PostType::find($request->parent_id);
                $node->appendNode($postType);
            }
            if ($postType->save()) {
                toastr()->success('Thêm mới danh mục thành công!', 'success');
                return redirect()->back();
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $postTypes = PostType::all();
        $postType = PostType::find($id);
        return view('admin.post-type.edit', compact('postType', 'postTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function update(PostTypeRequest $request, $id)
    {
        try {
            $postType = PostType::find($id);
            $params = $request->except('_token', 'image');
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                Storage::delete('/public/' . $postType->image);
                $request->image = uploadFile('postTypes', $request->file('image'));
                $params['image'] = $request->image;
            } else {
                $request->image = $postType->image;
            }
            if ($params['parent_id'] == 'none') {
                $params['parent_id'] = null;
            }
            if (!$request->slug) {
                $params['slug'] = Str::slug($params['name']);
            } else {
                $params['slug'] = Str::slug($request->slug);
            }
            // Lấy thông tin cũ của parent_id
            $oldParentId = $postType->parent_id;

            // Sử dụng DB transaction để bảo vệ tính toàn vẹn của nested set
            DB::beginTransaction();
            // Cập nhật thông tin cơ bản của danh mục
            $postType->update($params);

            // Nếu parent_id đã thay đổi, cập nhật vị trí của node trong cây
            if ($params['parent_id'] !== $oldParentId) {
                if ($params['parent_id'] === null) {
                    $postType->makeRoot();
                } else {
                    $newParent = PostType::find($params['parent_id']);
                    $postType->appendToNode($newParent)->save();
                }
            }

            // Commit transaction nếu mọi thứ thành công
            DB::commit();
            toastr()->success('Cập nhật danh mục thành công!', 'success');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                // Lỗi duplicate entry
                DB::rollBack(); // Lưu ý: Rollback transaction nếu xảy ra lỗi
                return redirect()->back()->withErrors(['slug' => 'Slug đã bị trùng lặp. Vui lòng nhập tên khác']);
            }
            toastr()->error('Có lỗi xảy ra !', 'error');
        }

        return redirect()->route('post-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id) {
            $deleted = PostType::where('id', $id)->delete();
            if ($deleted) {
                toastr()->success('Xóa danh mục thành công!', 'success');
            } else {
                toastr()->error('Có lỗi xảy ra', 'error');
            }
            return redirect()->route('post-type.index');
        }
    }

    public function trash(PostTypeRequest $request)
    {
        $deleteItems = PostType::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $deleteItems->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status == 0 || $status == 1) {
                $deleteItems->where('status', $status);
            } else if ($status == 'all') {
                $deleteItems->get();
            }
        }

        $deleteItems = $deleteItems->orderBy('id', 'DESC')->paginate(5);
        return view('admin.post-type.trash', compact('deleteItems'));
    }

    public function restore($id)
    {
        if ($id) {
            $restore = PostType::withTrashed()->find($id);
            $restore->restore();
            toastr()->success('Khôi phục danh mục thành công', 'success');
            return redirect()->route('post-type.trash');
        }
    }

    public function delete($id)
    {
        if ($id) {
            $deleted = PostType::onlyTrashed()->find($id);
            $deleted->forceDelete();
            toastr()->success('Xóa vĩnh viễn danh mục thành công', 'success');
            return redirect()->route('post-type.trash');
        }
    }

    public function updateStatus($id, Request $request)
    {
        $item = PostType::find($id);

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
            PostType::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các danh mục đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các danh mục đã chọn');
        }

    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = PostType::withTrashed()->whereIn('id', $ids);
            $voucher->restore();
            toastr()->success('Thành công', 'Thành công khôi phục danh mục');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các danh mục đã chọn');
        }
        return redirect()->route('post-type.trash');
    }

    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $voucher = PostType::withTrashed()->whereIn('id', $ids);
            $voucher->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn danh mục');

        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các danh mục đã chọn');
        }
        return redirect()->route('post-type.trash');
    }
}

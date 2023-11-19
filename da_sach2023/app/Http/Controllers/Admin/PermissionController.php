<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Permission::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $permission =  $query->orderBy('id', 'DESC')->get();
        return view('admin.role_permission.permission.index', compact('permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role_permission.permission.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $data = $request->all();
        $user = new Permission();
        $user->name = $data['name'];
        $user->display_name = $data['display_name'];
        $user->group = $data['group'];
        $user->save();
        toastr()->success('Cảm ơn! ' . $data['display_name'] . ' thêm thành công!');
        return redirect()->route('permission.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $permission = Permission::find($id);
        if (!$permission) {
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        return view('admin.role_permission.permission.edit', compact('permission'));
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
    public function update(PermissionRequest $request, $id)
    {
        if ($request->isMethod('POST')) {
            $params = $request->except('_token');
            $result = Permission::where('id', $id)->update($params);
            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('permission.form-update', ['id' => $id]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Permission::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('permission.list');
    }
    public function list_bin(Request $request)
    {
        $query = Permission::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $softDeletedPermission = $query->onlyTrashed()->get();
        return view('admin.role_permission.permission.bin', compact('softDeletedPermission'));
    }

    public function restore_bin(Request $request, $id)
    {
        $permission = Permission::withTrashed()->find($id);
        if ($permission) {
            $permission->restore();
            $permission->deleted_at = null;
            $permission->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('bin.list-permission');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $permission = Permission::withTrashed()->find($id);

        if ($permission && $permission->deleted_at !== null) {
            $permission->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('bin.list-permission');
        } else {
            abort(404);
        }
    }

    public function deleteAll(Request $request)
    {
        $ids = $request->ids;

        if ($ids) {
            Permission::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các quyền đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các quyền đã chọn');
        }
    }
    public function delete_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $permission = Permission::withTrashed()->whereIn('id', $ids);
            $permission->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn quyền');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các quyền đã chọn');
        }
        return redirect()->route('permision.list');
    }
    public function restore_bin_all(Request $request)
    {

        $ids = $request->ids;
        if ($ids) {
            $permission = Permission::withTrashed()->whereIn('id', $ids);
            $permission->restore();
            toastr()->success('Thành công', 'Thành công khôi phục quyền');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các quyền đã chọn');
        }
        return redirect()->route('permision.list');
    }
}

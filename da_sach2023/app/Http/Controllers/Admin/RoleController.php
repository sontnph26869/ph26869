<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Role::query();

        // Tìm kiếm theo name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $role =  $query->orderBy('id', 'DESC')->whereNotIn('name', ['Jungx-Admin'])->get();

        return view('admin.role_permission.role.index', compact('role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permission = Permission::all()->groupBy('group');
        // dd($permission);
        return view('admin.role_permission.role.add', compact('permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(RoleRequest $request)
    {

        $role = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'group' => $request->group,
        ]);
        $role->syncPermissions($request->input('permission'));


        toastr()->success('Thank!  add successfully!');
        return redirect()->route('role.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        if (!$role) {
            abort(404); // Nếu không tìm thấy bản ghi, trả về trang 404 hoặc xử lý tùy ý.
        }
        if (($role->id == 1)) {
            abort(404);
        } else {
            $permission = Permission::all()->groupBy('group');
            $get_permission_via_role = $role->permissions;
            return view('admin.role_permission.role.edit', compact('role', 'permission', 'get_permission_via_role'));
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
    public function update(RoleRequest $request, $id)
    {
        $role = Role::find($id);

        if (!$role) {
            // Handle the case where the role with the given ID doesn't exist.
        }

        if ($request->isMethod('POST')) {
            $params = $request->except('_token', '_method', 'permission'); // Exclude '_method' and 'permission' if they're not needed.
            $role->syncPermissions($request->input('permission', [])); // Assuming 'permission' is an array.

            $result = $role->update($params);

            if ($result) {
                toastr()->success('Cập nhật thành công!');
                return redirect()->route('role.form-update', ['id' => $id]);
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
        if ($id == 1) {
            toastr()->error('Không thể xóa vai trò này!');
            return redirect()->route('role.list');
        }
        Role::where('id', $id)->delete();
        toastr()->success('Xóa thành công!');
        return redirect()->route('role.list');
    }
    //thùng rác 
    public function list_bin(Request $request)
    {
        $query = Role::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        $softDeletedRoles = $query->onlyTrashed()->get();
        return view('admin.role_permission.role.bin', compact('softDeletedRoles'));
    }

    public function restore_bin(Request $request, $id)
    {
        $role = Role::withTrashed()->find($id);
        if ($role) {
            $role->restore();
            $role->deleted_at = null;
            $role->save();
            toastr()->success('Cập nhật thành công!');
            return redirect()->route('role.list');
        } else {
            abort(404);
        }
    }
    public function delete_bin(Request $request, $id)
    {
        $role = Role::withTrashed()->find($id);
        if ($role && $role->deleted_at !== null) {
            $role->forceDelete();
            toastr()->success('Xóa thành công!');
            return redirect()->route('role.list-role');
        } else {
            abort(404);
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            Role::whereIn('id', $ids)->delete();
            toastr()->success('Thành công xoá các vai trò đã chọn');
        } else {
            toastr()->warning('Không tìm thấy các vai trò đã chọn');
        }
    }
    public function delete_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $role = Role::withTrashed()->whereIn('id', $ids);
            $role->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn vai trò');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các vai trò đã chọn');
        }
        return redirect()->route('role.list');
    }
    public function restore_bin_all(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $role = Role::withTrashed()->whereIn('id', $ids);
            $role->restore();
            toastr()->success('Thành công', 'Thành công khôi phục vai trò');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các vai trò đã chọn');
        }
        return redirect()->route('role.list');
    }
}

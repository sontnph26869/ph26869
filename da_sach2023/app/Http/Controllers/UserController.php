<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Doctrine\ORM\EntityManager;
use Carbon\Carbon;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();

        if($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like','%' . $search . '%');
        }

        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }

        $user1 = $query->orderBy('id', 'DESC')->paginate(3);
        return view('admin.user.index', compact('user1'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::all();
        $permission = Permission::all();
        return view('admin.user.add', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {

        // $data = $request->all();

        $user = new User();
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        if($request->gender == 0) {
            $user->gender = 'Male';
        } else {
            $user->gender = 'Female';
        }
        if ($request->hasFile('avatar')) {
            $user->avatar = uploadFile('user', $request->file('avatar'));
        }
        $user->status = $request->status;
        $user->save();
        $user->assignRole($request->input('role'));
        toastr()->success('Cảm ơn ' . $request->name . ' thêm thành công!');
        return redirect()->route('user.add');
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
        $user = User::find($id);
        $roles = Role::all();
        $userRoles = $user->getRolenames();
        return view('admin.user.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LoginRequest $request, $id)
    {
        //

        $user = new User();
        $user = User::find($id);
        $roles = Role::all();

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->gender = $request->gender;
        if ($request->hasFile('avatar')) {
            $user->avatar = uploadFile('user', $request->file('avatar'));
        }
        $user->status = $request->status;
        if ($request->password == null || $request->password == '') {
            $user->password = $user->password;
        } else {
            $user->password = $request->password;
        }
        $user->save();
        $user->assignRole($request->input('role'));
        toastr()->success('Cập nhật ' . $request->name . ' thành công!');
        return redirect()->route('user.index');
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

        User::find($id)->delete();
        toastr()->success('Xóa sản phẩm thành công!');
        return redirect()->route('user.index');
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            User::whereIn('id', $ids)->delete();
            toastr()->success( 'Thành công xoá các người dùng đã chọn');
        } else {
            toastr()->warning( 'Không tìm thấy người dùng  đã chọn');
        }
    }
    public function trash(Request $request)
    {
        $query = User::onlyTrashed();

        // Tìm kiếm theo name trong trash
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }
        // Lọc theo status trong trash
        if ($request->has('status')) {
            $status = $request->input('status');
            if ($status != 0) {
                $query->where('status', $status);
            }
        }
        $users = $query->orderBy('id', 'DESC')->paginate(3);
        return view('admin.user.trash', [
            'users' => $users
        ]);
    }
    public function permanentlyDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->forceDelete();
        toastr()->success('Thành công', 'Thành công xoá vĩnh viễn người dùng');
        return redirect()->route('user.trash');
    }
    public function permanentlyDeleteSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $user = User::withTrashed()->whereIn('id', $ids);
            $user->forceDelete();
            toastr()->success('Thành công', 'Thành công xoá vĩnh viễn người dùng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy các người dùng đã chọn');
        }
        return redirect()->route('user.trash');
    }

    public function restoreSelected(Request $request)
    {
        $ids = $request->ids;
        if ($ids) {
            $user = User::withTrashed()->whereIn('id', $ids);
            $user->restore();
            toastr()->success('Thành công', 'Thành công khôi phục người dùng');
        } else {
            toastr()->warning('Thất bại', 'Không tìm thấy cácngười dùng đã chọn');
        }
        return redirect()->route('user.trash');
    }
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
        toastr()->success(' Khôi phục người dùng  thành công!', 'success');
        return redirect()->route('user.trash');
    }
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        $user->forceDelete();
        toastr()->success(' Xóa người dùng  thành công!', 'success');
        return redirect()->route('user.trash');
    }
    public function cleanupTrash()
    {
        $thirtyDaysAgo = Carbon::now()->subDays(1);
        User::onlyTrashed()->where('deleted_at', '<', $thirtyDaysAgo)->forceDelete();
        return redirect()->route('index.user')->withSuccess('Đã xoá vĩnh viễn khu vực trong thùng rác');
    }
    public function updateStatus(Request $request, $id)
    {
        $item = user::find($id);

        if (!$item) {
            return response()->json(['message' => 'Không tìm thấy mục'], 404);
        }
        $newStatus = $request->input('status');
        $item->status = $newStatus;
        $item->save();

        return response()->json(['message' => 'Cập nhật trạng thái thành công'], 200);
    }

    public function role(Request $request, $id)
    {
        $user = User::find($id);
        $role = Role::orderBy('id', 'DESC')->get();
        $permission = Permission::orderBy('id', 'DESC')->get();
        $check_role = $user->roles->first();
        return view('admin.user.role', compact('user', 'role', 'check_role', 'permission'));
    }

    public function permission(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->roles->isEmpty()) {
            toastr()->error('Error! Add roles first!');
            return redirect()->route('dashboard');
        }
        $permission = Permission::orderBy('id', 'DESC')->get();
        $name_role = $user->roles->first()->name;
        $get_permission_via_role = $user->getPermissionsViaRoles();
        return view('admin.user.permission', compact('user', 'name_role', 'permission', 'get_permission_via_role'));
    }

    public function insert_role(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $user->syncRoles($data['role']);
        $role_id = $user->roles->first()->id;
        toastr()->success('Cập nhật vai trò thành công!');
        return redirect()->route('admin.dashboard');
    }

    public function insert_permission(Request $request, $id)
    {
        $data = $request->all();
        $user = User::find($id);
        $role_id = $user->roles->first()->id;
        $role = Role::find($role_id);
        $role->syncPermissions($data['permission']);
        toastr()->success('Cập nhật quyền thành công!');
        return redirect()->route('admin.dashboard');
    }
}

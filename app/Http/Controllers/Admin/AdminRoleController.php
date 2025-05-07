<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.role.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        return view('admin.role.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255|unique:roles,name',
                'description' => 'required',
                'permission_id' => 'required|array|min:1',
                'permission_id.*' => 'exists:permissions,id'
            ],
            [
                'name.required' => 'Tên vai trò không được để trống',
                'name.max' => 'Tên vai trò không được quá 255 ký tự',
                'name.unique' => 'Tên vai trò đã tồn tại',
                'description.required' => 'Mô tả không được để trống',
                'permission_id.required' => 'Bạn phải chọn ít nhất một quyền',
                'permission_id.min' => 'Bạn phải chọn ít nhất một quyền',
                'permission_id.*.exists' => 'Danh sách quyền không tồn tại'
            ]
        );
        $role = Role::create([
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "created_date_int" => time()
        ]);

        $role->permissions()->attach($request->input('permission_id'));
        return  redirect()->route('role.index')->with('success', 'Đã thêm vai trò thành công');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        $permissionIds = $role->permissions->pluck('id')->toArray();
        return view('admin.role.edit', compact('permissions', 'role', 'permissionIds'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|max:255|unique:roles,name,' . $role->id,
            'description' => 'required',
            'permission_id' => 'nullable|array',
            'permission_id.*' => 'exists:permissions,id'
        ]);
        $role->update([
            'name' => $request->input('name'),
            'description' => $request->input('description')
        ]);

        $role->permissions()->sync($request->input('permission_id', []));
        return redirect()->route('role.index')->with('success', 'Đã cập nhật vai trò thành công');
    }

    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->delete();
        return redirect()->route('role.index')->with('success', 'Đã xóa vai trò thành công');
    }
}

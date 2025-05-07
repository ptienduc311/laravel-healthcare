<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

class AdminPermissionController extends Controller
{
    public function index()
    {
        // return view('admin.permission.list');
    }

    public function create()
    {
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        
        return view('admin.permission.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ],
            [
                'name.required' => 'Tên quyền không được để trống',
                'name.max' => 'Tên quyền không được quá 255 ký tự',
                'slug.required' => 'Slug quyền không được để trống',
            ]
        );

        Permission::create([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description'),
            'created_date_int' => time(),
        ]);
        return redirect('admin/permission/add')->with('success', 'Bạn đã thêm quyền thành công');
    }

    public function edit(string $id)
    {     
        $permissions = Permission::all()->groupBy(function ($permission) {
            return explode('.', $permission->slug)[0];
        });
        $permission = Permission::find($id);
        // dd($permission->name);
        return view('admin.permission.edit', compact('permissions', 'permission'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'name' => 'required|max:255',
                'slug' => 'required',
            ],
            [
                'name.required' => 'Tên quyền không được để trống',
                'name.max' => 'Tên quyền không được quá 255 ký tự',
                'slug.required' => 'Slug quyền không được để trống',
            ]
        );
        Permission::where('id', $id)->update([
            'name' => $request->input('name'),
            'slug' => $request->input('slug'),
            'description' => $request->input('description')
        ]);
        return redirect()->route('permission.add')->with('success', 'Đã cập nhật thành công');
    }

    public function destroy(string $id)
    {
        $permission = Permission::findOrFail($id);
        $permission->roles()->detach();
        $permission->delete();
        return redirect()->route('permission.add')->with('success', 'Đã xóa thành công');
    }
}

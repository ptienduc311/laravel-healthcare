<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $userRoleIds = $user->roles->pluck('id')->toArray();
        return view("admin.user.edit", compact('user', 'roles', 'userRoleIds'));
    }

    public function update(Request $request, User $user)
    {
        // dd($request);
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
                'confirmed' => 'Xác nhận mật khẩu không thành công',
                'string' => ':attribute phải là chuỗi',
                'exists' => ':attribute không hợp lệ',        
            ],
            [
                'name' => 'Tên người dùng',
                'email' => "Email",
                'password' => 'Mật khẩu',
                'roles' => 'Vai trò'
            ]
        );

        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }
        $user->update($data);
        $user->roles()->sync($request->input('roles'));
        return redirect()->back()->with('success', 'Cập nhật người dùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCreateAccount;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $roles = Role::all();
        return view('admin.user.add', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
                'confirmed' => 'Mật khẩu xác nhận không đúng',
                'string' => ':attribute phải là chuỗi',
                'array' => ':attribute phải là mảng',
                'exists' => ':attribute không hợp lệ',
                'roles.required' => 'Bạn phải chọn ít nhất vai trò',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'roles' => 'Vai trò'
            ]
        );
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $roles = $request->input('roles');
        $is_activate = $request->has('is_activate');
        $is_create = $request->input('action') === 'create';
        $email_verified_at = $is_activate ? now() : null;

        $base_token = $request->name . $email . time();
        $confirm_token = md5('confirm:' . $base_token);
        $urlActive = route('register.active', $confirm_token);

        $cancel_token = md5('cancel:' . $base_token);
        $urlCancel = route('register.cancel', $cancel_token);

        $selectedRoles = Role::whereIn('id', $roles)->get();
        $strRoles = $selectedRoles->pluck('name')->implode(', ');
        $isAdmin = $selectedRoles->contains('slug_role', 'admin');

        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'status' => 1,
            'email_verified_at' => $is_create || $isAdmin ? now() : $email_verified_at,
        ];

        if (!$is_create && !$isAdmin) {
            $userData['confirm_token'] = $confirm_token;
            $userData['cancel_token'] = $cancel_token;
        }

        $user = User::create($userData);
        foreach ($selectedRoles as $role) {
            UserRole::create([
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);
        }
        
        if (!$is_create || !$isAdmin) {
            $mailData = [
                'username' => $name,
                'email' => $email,
                'password' => $password,
                'roles' => $strRoles,
                'is_active' => $isAdmin ? true : $is_activate,
                'urlActive' => $urlActive,
                'urlCancel' => $urlCancel,
            ];
            Mail::to($email)->send(new SendMailCreateAccount($mailData));
        }
        return redirect('admin/user')->with('success', 'Đã tạo tài khoản thành công.');
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
                'confirmed' => 'Mật khẩu xác nhận không đúng',
                'string' => ':attribute phải là chuỗi',
                'array' => ':attribute phải là mảng',
                'exists' => ':attribute không hợp lệ'
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
        return redirect('admin/user')->with('success', 'Cập nhật người dùng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return redirect('admin/user')->with('success', 'Xóa người dùng thành công.');
    }
}

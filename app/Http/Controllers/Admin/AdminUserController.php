<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SendMailCreateAccount;
use App\Models\Doctor;
use App\Models\MedicalSpecialty;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        $specialties = MedicalSpecialty::where('status', 1)->get();
        
        return view('admin.user.add', compact('roles', 'specialties'));
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
                'role' => 'required|exists:roles,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
                'confirmed' => 'Mật khẩu xác nhận không đúng',
                'string' => ':attribute phải là chuỗi',
                'exists' => ':attribute không hợp lệ',
                'role.required' => 'Bạn phải chọn ít nhất một vai trò',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
                'password' => 'Mật khẩu',
                'role' => 'Vai trò'
            ]
        );
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');
        $roleId  = $request->input('role');
        $is_activate = $request->has('is_activate');
        $doctorId = $request->input('doctor_id');
        $is_create = $request->input('action') === 'create';
        $email_verified_at = $is_activate ? now() : null;

        $base_token = $request->name . $email . time();
        $confirm_token = md5('confirm:' . $base_token);
        $urlActive = route('register.active', $confirm_token);

        $cancel_token = md5('cancel:' . $base_token);
        $urlCancel = route('register.cancel', $cancel_token);

        $role = Role::find($roleId);
        $isAdmin = $role->slug_role === 'admin';
        $isDoctor = $role->slug_role === 'doctor';
        // dd($role, $isAdmin, $isDoctor);

        if ($isDoctor) {
            $checkDoctor = Doctor::where('id', $doctorId)->whereNull('user_id')->exists();
            if(!$checkDoctor){
                return redirect()->back()->with('error', 'Bác sĩ không tồn tại hoặc đã liên kết tài khoản.');
            }
        }

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
        UserRole::create([
            'role_id' => $role->id,
            'user_id' => $user->id
        ]);

        if ($isDoctor) {
            if ($doctorId) {
                Doctor::where('id', $doctorId)
                    ->whereNull('user_id')
                    ->update(['user_id' => $user->id]);
            } else {
                $slugName = Str::slug($name);
                Doctor::create([
                    'name' => $name,
                    'slug_name' => $slugName,
                    'status' => 1,
                    'created_date_int' => time(),
                    'user_id' => $user->id,
                ]);
            }
        }
        
        if (!$is_create || !$isAdmin) {
            $mailData = [
                'username' => $name,
                'email' => $email,
                'password' => $password,
                'roles' => $role->name,
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
        $userRoleId = $user->roles->pluck('id')->first();;
        $specialties = MedicalSpecialty::where('status', 1)->get();
        $isDoctor = $user->hasRole('doctor');

        return view("admin.user.edit", compact('user', 'roles', 'userRoleId', 'specialties', 'isDoctor'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed',
                'role' => 'required|exists:roles,id',
            ],
            [
                'required' => ':attribute không được để trống',
                'min' => ':attribute có độ dài ít nhất :min ký tự',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
                'confirmed' => 'Mật khẩu xác nhận không đúng',
                'string' => ':attribute phải là chuỗi',
                'exists' => ':attribute không hợp lệ',
                'role.required' => 'Bạn phải chọn ít nhất một vai trò',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => "Email",
                'password' => 'Mật khẩu',
                'role' => 'Vai trò'
            ]
        );
        $isDoctor = $user->hasRole('doctor');
        $roleIdNew = $request->input('role');
        $roleIdOld = optional($user->roles->first())->id;
        $roleDoctor = Role::where('slug_role', 'doctor')->first()->id;
        $doctorIdNew = $request->input('doctor_id');
        $doctorIdOld = $user->doctor?->id;
        // dd($request, $isDoctor, $roleIdNew, $roleIdOld, $roleDoctor, $doctorIdNew, $doctorIdOld);

        //Nếu user là doctor
        if($isDoctor){
            //Là bác sĩ
            if($roleIdNew ==  $roleDoctor){
                //Nếu có doctor_id
                if($doctorIdNew){
                    if($doctorIdNew == $doctorIdOld){
                        dd('Vai trò vẫn là bác sĩ, vẫn là bác sĩ cũ')   ;
                    }
                    else{
                        dd('Vai trò vẫn là bác sĩ, nhưng là bác sĩ mới');
                    }
                }
                else{
                    dd('Vai trò vẫn là bác sĩ, nhưng chưa chọn bác sĩ');
                }
            }
            else{
                dd('Đã từng là bác sĩ');
            }
        }
        else{
            //Nếu vẫn là role cũ
            if($roleIdNew == $roleIdOld){
                dd('Vẫn là vai trò cũ');
            }
            else{
                //Nếu là doctor
                if($roleIdNew == $roleDoctor){
                    //Nếu có doctor_id
                    if($doctorIdNew){
                        dd('Chuyển đổi vai trò thành bác sĩ và đã lựa chọn bác sĩ');
                    }
                    else{
                        dd('Chuyển đổi vai trò thành bác sĩ và chưa chọn bác sĩ');
                    }
                }
                else{
                    dd('Chuyển đổi vai trò');
                }
            }
        }
        dd('hỏng');

        // $data = [
        //     'name' => $request->input('name'),
        //     'email' => $request->input('email'),
        // ];
        // if ($request->filled('password')) {
        //     $data['password'] = Hash::make($request->input('password'));
        // }
        // $user->update($data);
        // $user->roles()->sync($request->input('roles'));
        // return redirect('admin/user')->with('success', 'Cập nhật người dùng thành công.');
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

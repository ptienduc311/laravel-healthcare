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
    public function index(Request $request)
    {
        $roles = Role::all();
        $authId = Auth::id();

        $users = User::with('roles')
            ->when($request->filled('role_id'), function ($query) use ($request) {
                $query->whereHas('roles', function ($q) use ($request) {
                    $q->where('roles.id', $request->role_id);
                });
            })
            ->when($request->filled('is_account'), function ($query) use ($request) {
                if ($request->is_account == 1) {
                    $query->whereNotNull('email_verified_at');
                } elseif ($request->is_account == 2) {
                    $query->whereNull('email_verified_at');
                }
            })
            ->when($request->filled('is_block'), function ($query) use ($request) {
                if ($request->is_block == 1) {
                    $query->where('status', 1);
                } elseif ($request->is_block == 2) {
                    $query->where('status', 2);
                }
            })
            ->when($request->filled('keyword'), function ($query) use ($request) {
                $keyword = $request->keyword;
                $query->where(function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
                });
            })
            ->orderByRaw("id = ? DESC", [$authId])
            ->orderBy('created_at', 'desc')
            ->paginate(10)->withQueryString();

        return view('admin.user.list', compact('roles', 'users'));
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
        // dd($role, $isAdmin, $isDoctor, $doctorId);

        if ($isDoctor && !empty($doctorId)) {
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

        if (!$is_create) {
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
        
        if (!$is_create) {
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
        $roleDoctor = Role::where('slug_role', 'doctor')->first()->id;
        $doctorIdNew = $request->input('doctor_id');
        $doctorIdOld = $user->doctor?->id;
        $is_activate = $request->has('is_activate');
        $time_active = $user->email_verified_at ? $user->email_verified_at : now();
        $email_verified_at = $is_activate ? $time_active : null;
        // dd($request, $isDoctor, $roleIdNew, $roleIdOld, $roleDoctor, $doctorIdNew, $doctorIdOld);
        $name = $request->input('name');
        $email = $request->input('email');

        if ($roleIdNew == $roleDoctor && !empty($doctorId) && $doctorIdNew != $doctorIdOld) {
            $checkDoctor = Doctor::where('id', $doctorIdNew)->whereNull('user_id')->exists();
            if(!$checkDoctor){
                return redirect()->back()->with('error', 'Bác sĩ không tồn tại hoặc đã liên kết tài khoản.');
            }
        }

        $dataUser = [
            'name' => $name,
            'email' => $email,
            'email_verified_at' => $email_verified_at
        ];
        if ($request->filled('password')) {
            $dataUser['password'] = Hash::make($request->input('password'));
        }
        $user->update($dataUser);
        $user->roles()->sync($roleIdNew);

        if($isDoctor){
            if($roleIdNew ==  $roleDoctor){
                if($doctorIdNew){
                    if ($doctorIdNew != $doctorIdOld) {
                        $user->doctor?->update(['user_id' => null]);
                        Doctor::where('id', $doctorIdNew)->update(['user_id'=> $user->id]);
                    }
                }
                else{
                    $user->doctor?->update(['user_id' => null]);
                    Doctor::create([
                        'name' => $name,
                        'slug_name' => Str::slug($name),
                        'status' => 1,
                        'created_date_int' => time(),
                        'user_id' => $user->id,
                    ]);
                }
            }
            else{
                $user->doctor->update(['user_id' => null]);
            }
        }
        elseif ($roleIdNew == $roleDoctor) {
            if($doctorIdNew){
                Doctor::where('id', $doctorIdNew)->update(['user_id'=> $user->id]);
            }
            else{
                Doctor::create([
                    'name' => $name,
                    'slug_name' => Str::slug($name),
                    'status' => 1,
                    'created_date_int' => time(),
                    'user_id' => $user->id,
                ]);
            }
        }
        return redirect('admin/user')->with('success', 'Cập nhật người dùng thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if(Auth::id() == $user->id){
            return redirect()->back()->with('error', 'Không được xóa tài khoản của bạn.');
        }
        $user->roles()->detach();
        $user->delete();
        return redirect('admin/user')->with('success', 'Xóa người dùng thành công.');
    }

    public function updateStatus(int $userId, int $statusCode){
        if(Auth::id() == $userId){
            return redirect()->back()->with('error', 'Không được chặn tài khoản của bạn.');
        }

        User::where('id', $userId)->update(['status' => $statusCode]);
        return redirect()->back()->with('success', 'Cập nhật người dùng thành công.');
    }
}

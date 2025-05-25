<?php

namespace App\Http\Controllers;

use App\Mail\SendMailResetPassword;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function handle(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8',
            ],
            [
                'email.required' => 'Vui lòng nhập địa chỉ E-mail.',
                'email.email' => 'E-mail không đúng định dạng.',
                'email.exists' => 'E-mail không tồn tại trong hệ thống.',
                'password.required' => 'Vui lòng nhập mật khẩu của bạn.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if (is_null($user->email_verified_at) || is_null($user->status)) {
                Auth::logout();
                return redirect()->back()->with('error', 'Vui lòng kiểm tra email để xác nhận');
            }
            
            if ($user->roles->contains('slug_role', 'benh-nhan')) {
                if ($user->status != 1) {
                    Auth::logout();
                    return redirect('/login')->with('blocked', 'Tài khoản đã bị chặn');
                }
                return redirect()->route('home');
            } else {
                return redirect()->intended('admin/dashboard');
            }
        } else {
            return redirect()->back()->withErrors(['password' => 'Mật khẩu không đúng.'])->withInput();
        }
    }

    public function reset()
    {
        return view('auth.forget-password');
    }

    public function sendLinkResetEmail(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email|exists:users,email'
            ],
            [
                'email.required' => 'E-mail không được để trống',
                'email.email' => 'E-mail không đúng định dạng',
                'email.exists' => 'E-mail chưa được đăng ký'
            ]
        );

        $user = User::where('email', $request->email)->first();
        $email = $request->email;
        $username = $user->name;

        $currentTime = Carbon::now()->toDateTimeString();;
        $randomBytes = random_bytes(16);
        $reset_token = hash('sha256', $currentTime . $randomBytes . $email);
        $urlResetPass = route('new.pass', $reset_token);

        $user->update(['reset_token' => $reset_token]);

        $data = [
            'username' => $username,
            'urlResetPass' => $urlResetPass,
        ];

        Mail::to($email)->send(new SendMailResetPassword($data));
        return redirect()->back()->with('success', 'Đã gửi mã khôi phục đến email của bạn');
    }

    public function newPass($reset_token)
    {
        return view('auth.reset-password', compact('reset_token'));
    }

    public function updatePass(Request $request, $reset_token)
    {
        $request->validate(
            [
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ],
            [
                'required' => ':attribute không được để trống',
                'string' => ':attribute phải là chuỗi',
                'min' => ':attribute phải có ít nhất :min kí tự',
                'confirmed' => 'Mật khẩu xác nhận không khớp',
            ],
            [
                'password' => 'Mật khẩu'
            ]
        );
        $exists = User::where('reset_token', $reset_token)->exists();
        if ($exists) {
            $user = User::where('reset_token', $reset_token)->first();
            $user->password = Hash::make($request->password);
            $user->reset_token = NULL;
            $user->save();
            return redirect()->route('login')->with('success', 'Đã thay đổi mật khẩu thành công');
        } else {
            return redirect()->route('reset.pass')->with('error', 'Vui lòng kiểm tra lại email hoặc nhập lại email của bạn');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }

    public function loginGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function handleLoginGoogleCallback(){
        try{
            $user = Socialite::driver('google')->user();
            $findUserGoogleId = User::where('google_id', $user->id)->first();
            $findUserEmail = User::where('email', $user->email)->first();
            
            if(!is_null($findUserGoogleId)){
                // dd('có google id');
                Auth::login($findUserGoogleId);
                return $this->redirectByRole($findUserGoogleId);
            }
            else{
                if(!is_null($findUserEmail)){
                    // dd('chưa có google id nhưng đã có email');
                    $findUserEmail->update(['google_id' => $user->id]);
                    Auth::login($findUserEmail);
                    return $this->redirectByRole($findUserEmail);
                }
                else{
                    // dd('chưa có google id và chưa có tài khoản');
                    $userNew = User::create([
                        'name' => $user->name,
                        'email' => $user->email,
                        'password' => Hash::make($user->id),
                        'status' => 1,
                        'email_verified_at' => now(),
                        'google_id' => $user->id
                    ]);

                    $role = Role::where('slug_role', 'benh-nhan')->first();
                    if ($role) {
                        $userNew->roles()->attach($role->id, [
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }

                    Auth::login($userNew);
                    return redirect()->route('home');
                }
            }
        } catch (\Exception) {
            return redirect()->route('login')->with('no-access', 'Đăng nhập Google thất bại.');
        }
    }

    private function redirectByRole($user)
    {
        $roles = $user->roles;

        if($user->status == 2){
            Auth::logout();
            return redirect('/login')->with('blocked', 'Tài khoản đã bị chặn');
        }

        if (is_null($user->email_verified_at) || is_null($user->status)) {
            Auth::logout();
            return redirect('/login')->with('error', 'Vui lòng kiểm tra email để xác nhận');
        }

        if ($roles->contains('slug_role', 'benh-nhan')) {
            return redirect()->route('home');
        }

        return redirect()->intended('admin/dashboard');
    }
}

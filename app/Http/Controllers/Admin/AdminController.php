<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function profile()
    {
        return view('admin.profile');
    }

    public function profile_update(Request $request){
        $request->validate(
            [
                'username' => 'required|string|max:255',
                'password' => 'nullable|string|min:8|confirmed',
            ],
            [
                'username.required' => 'Vui lòng nhập tên đăng nhập.',
                'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
                'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $data = [
            'name' => $request->username,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
    
        $user->update($data);
    
        return back()->with('success', 'Cập nhật tài khoản thành công.');
    }

    public function site()
    {
        $site = Site::findOrFail(1);
        return view('admin.site', compact('site'));
    }

    public function site_update(Request $request){
        $phone = $request->phone;
        $hotline = $request->hotline;
        $email = $request->email;
        $address = $request->address;
        $link_facebook = $request->link_facebook;
        $link_zalo = $request->link_zalo;
        $link_youtube = $request->link_youtube;
        Site::where('id', 1)->update([
            'phone' => $phone,
            'hotline' => $hotline,
            'email' => $email,
            'address' => $address,
            'link_facebook' => $link_facebook,
            'link_zalo' => $link_zalo,
            'link_youtube' => $link_youtube,
        ]);        
    
        return back()->with('success', 'Cập nhật tài khoản thành công.');
    }
}

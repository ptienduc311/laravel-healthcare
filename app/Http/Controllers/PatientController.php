<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function info()
    {
        $patient = Auth::user();
        return view('themes.info-patient', compact('patient'));
    }

    public function update(Request $request)
    {
        $patient = Auth::user();
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $patient->id,
            ],
            [
                'required' => ':attribute không được để trống',
                'max' => ':attribute có độ dài tối đa :max ký tự',
                'email' => ':attribute không đúng định dạng',
                'unique' => ':attribute đã tồn tại',
                'string' => ':attribute phải là chuỗi',
            ],
            [
                'name' => 'Tên người dùng',
                'email' => 'Email',
            ]
        );

        $name = $request->name;
        $phone = $request->phone;
        $birth = Carbon::createFromFormat('d/m/Y', $request->birth)->format('d/m/Y');
        $email = $request->email;
        $gender = $request->gender;
        $address = $request->address;
        $province_id = $request->province_id;
        $district_id = $request->district_id;
        $ward_id = $request->ward_id;

        if($email != $patient->email){
            return redirect()->back()->with('warning', 'Không được cập nhật email');
        }

        /** @var \App\Models\User $patient */
        $patient->update([
            'name' => $name,
            'phone' => $phone,
            'birth' => $birth,
            'gender' => $gender,
            'address' => $address,
            'province_id' => $province_id,
            'district_id' => $district_id,
            'ward_id' => $ward_id
        ]);
        return redirect()->back()->with('success', 'Cập nhật thông tin thành công.');
    }
}

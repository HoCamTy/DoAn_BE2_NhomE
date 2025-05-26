<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer; // dùng Customer thay vì User

class ResetPassword extends Controller
{
    public function showForm()
    {
        return view('auth.reset-password');
    }

    public function handleReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6|confirmed', // cần có field new_password_confirmation
        ]);

        $customer = Customer::where('email', $request->email)->first();

        if (!$customer) {
            return back()->with('message', 'Không tìm thấy email này trong hệ thống.');
        }

        $customer->password = Hash::make($request->new_password);
        $customer->save();

        return back()->with('message', 'Mật khẩu đã được cập nhật thành công.');
    }
}

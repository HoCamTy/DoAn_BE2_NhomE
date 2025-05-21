<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    // Hiển thị form đặt lại mật khẩu
    public function showResetForm()
    {
        return view('auth.reset-password'); // view ở resources/views/auth/reset-password.blade.php
    }

    // Xử lý đặt lại mật khẩu
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('login')->with('success', 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập lại.');
    }
}

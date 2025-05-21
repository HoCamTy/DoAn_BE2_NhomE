<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function showForm()
    {
        return view('auth.reset-password');
    }

    public function handleReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'new_password' => 'required|min:6|confirmed', // thêm confirmed
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('message', 'Không tìm thấy email này trong hệ thống.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('message', 'Mật khẩu đã được cập nhật thành công.');
    }
}

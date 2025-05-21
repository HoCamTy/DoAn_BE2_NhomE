<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;  // đổi sang User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    $validated = $request->validate([
        'username' => 'required|string|unique:users,username',
        'email' => 'required|string|email|unique:users,email',
        'phone' => 'required|string',   // thêm dòng này
        'password' => 'required|string|min:8|confirmed',
    ]);

    User::create([
        'username' => $validated['username'],
        'email' => $validated['email'],
           'phone' => $validated['phone'],  // nhớ thêm vào đây luôn
        'password' => Hash::make($validated['password']),
    ]);

    return redirect()->route('login')->with('success', 'Đăng ký thành công!');
}

}

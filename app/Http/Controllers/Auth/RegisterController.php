<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
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
            'email' => 'required|string|email|unique:users,email',
            'phone' => 'required|string',  
            'password' => 'required|string|min:8|confirmed',
        ]);

        Customer::create([
            'email' => $validated['email'],
            'phone' => $validated['phone'], 
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công!');
    }

}


<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
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
        dd(1514);
        $validated = $request->validate([
            'customer_name'=>'required',
            'phone' => ['required', 'string', 'regex:/^[0-9]{10}$/', 'unique:customers,phone'],
            'email' => 'required|string|email|max:255|unique:customers,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            Customer::create([
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            return redirect()->intended('login')->with('message', 'Đăng ký thành công. Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return back()
                ->withInput($request->except('password'))
                ->withErrors(['error' => 'Có lỗi xảy ra khi đăng ký.']);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\User;

class LoginController extends Controller
{
    protected function username()
    {
        return 'username';
    }
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->intended('admin/dashboard');
        }
        if (Auth::guard('customer')->check()) {
            return redirect()->intended('customer/dashboard');
        }
        return view('auth.login');
    }

    /**
     * Handle the login request.
     */
    public function login(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Try admin login first
        if (Auth::guard('web')->attempt($credentials)) {
            // dd(1424);
            return redirect()->intended('admin/dashboard');
        }

            // dd(142416525);

        // Try customer login
        $customer = Customer::where('phone', $credentials['username'])->first();
        if ($customer) {
            // If customer has no password set, allow login with just phone
            if (is_null($customer->password) && $customer->phone == $credentials['password']) {
                Auth::guard('customer')->login($customer);
                return redirect()->intended('customer/dashboard');
            }
            // If password is set, verify it
            else if (!is_null($customer->password) && Hash::check($credentials['password'], $customer->password)) {
                Auth::guard('customer')->login($customer);
                return redirect()->route('index');
            }
        }

        return back()->withErrors([
            'username' => 'Thông tin đăng nhập không chính xác.',
        ]);
    }

    /**
     * Handle the logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

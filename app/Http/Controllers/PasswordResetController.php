<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForm()
    {
        return view('crud_user.forgot_password');
    }
    
    public function processRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Tìm user bằng email
        $user = DB::table('users')->where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Không tìm thấy tài khoản với email này.'])->withInput();
        }
        
        // Tạo token ngẫu nhiên
        $token = Str::random(60);
        
        // Lưu token vào column remember_token
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'remember_token' => $token
            ]);
        
        // Hiển thị form đặt lại mật khẩu
        return view('crud_user.reset_password', [
            'token' => $token, 
            'email' => $request->email
        ]);
    }
    
    public function resetPassword(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'token' => 'required'
        ], [
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'token.required' => 'Token không hợp lệ.'
        ]);
        
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        
        // Kiểm tra token có hợp lệ không
        $user = DB::table('users')
            ->where('email', $request->email)
            ->where('remember_token', $request->token)
            ->first();
            
        if (!$user) {
            return redirect()->route('forgot-password')
                ->withErrors(['email' => 'Token không hợp lệ hoặc đã hết hạn.']);
        }
        
        // Cập nhật mật khẩu
        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'password' => Hash::make($request->password),
                'remember_token' => null  // Xóa token
            ]);
            
        return redirect('/login')
            ->with('status', 'Mật khẩu đã được đặt lại thành công! Vui lòng đăng nhập với mật khẩu mới.');
    }
}
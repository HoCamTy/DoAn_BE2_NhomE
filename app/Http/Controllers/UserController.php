<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; // Thêm DB facade

class UserController extends Controller
{
    /**
     * Thêm constructor với middleware crud_user
     */
    public function __construct()
    {
        $this->middleware('crud_user'); // Đã sửa: Thêm middleware 'crud_user'
    }
    
    public function show()
    {
        try {
            // Lấy thông tin người dùng đăng nhập
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')
                    ->withErrors(['auth' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.']);
            }
            
            // Sử dụng full_name thay vì name
            $userName = $user->full_name;
            $userEmail = $user->email;
            $userPhone = $user->phone ?? 'Chưa có số điện thoại';
            
            return view('thongtincanhan.profile', compact('userName', 'userEmail', 'userPhone'));
        } catch (\Exception $e) {
            // Ghi log lỗi...
            return redirect()->route('login')->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()]);
        }
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return redirect()->route('login')
                    ->withErrors(['auth' => 'Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.']);
            }
            
            // Validate dữ liệu
            $validated = $request->validate([
                'userEmail' => 'required|email|unique:users,email,'.$user->id,
                'userPhone' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:11',
            ]);
            
            // Cập nhật bằng DB thay vì model trong trường hợp model có vấn đề
            DB::table('users')
                ->where('id', $user->id)
                ->update([
                    'email' => $validated['userEmail'],
                    'phone' => $validated['userPhone'] ?? $user->phone
                ]);
            
            // Chuyển về trang hiện tại với thông báo thành công
            return back()->with('message', 'Thông tin đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()])->withInput();
        }
    }
}
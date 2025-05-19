<?php
// app/Http/Controllers/ProfileController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('login')->withErrors('Bạn cần đăng nhập để xem thông tin cá nhân');
        }
        
        return view('profile.index', [
            'user' => $user
        ]);
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect('login')->withErrors('Bạn cần đăng nhập để cập nhật thông tin cá nhân');
        }
        
        $request->validate([
            'email' => 'required|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|regex:/^[0-9]+$/|min:10|max:11',
        ]);
        
        try {
            $updateData = [
                'email' => $request->email,
            ];
            
            if ($request->filled('phone')) {
                $updateData['phone'] = $request->phone;
            }
            
            DB::table('users')
                ->where('id', $user->id)
                ->update($updateData);
            
            return back()->with('success', 'Cập nhật thông tin cá nhân thành công');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Đã có lỗi xảy ra: ' . $e->getMessage()]);
        }
    }
}
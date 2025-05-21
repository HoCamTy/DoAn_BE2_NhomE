<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;

class StaffController extends Controller
{
      public function index(Request $request) {
        $keyword = $request->input('keyword');

        $staffs = Staff::when($keyword, function ($query, $keyword) {
                return $query->where('staff_name', 'like', "%$keyword%")
                            ->orWhere('staff_phone', 'like', "%$keyword%")
                            ->orWhere('email', 'like', "%$keyword%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

    return view('staffs.index', compact('staffs'));
    }

    public function destroy($id) {
        Staff::destroy($id);
        return redirect()->route('staffs.index')->with('success', 'Xóa thành công');
    }
}

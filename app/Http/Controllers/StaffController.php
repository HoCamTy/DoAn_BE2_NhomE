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

    public function create() {
        return view('staffs.create');
    }

    public function store(Request $request) {
        $request->validate([
            'staff_name' => 'required',
            'staff_phone' => 'required|unique:staffs',
            'email' => 'nullable|email',
        ]);
        Staff::create($request->all());
        return redirect()->route('staffs.index')->with('success', 'Thêm thành công');
    }

    public function edit($id) {
        $staff = Staff::findOrFail($id);
        return view('staffs.edit', compact('staff'));
    }

    public function update(Request $request, $id) {
        $staff = Staff::findOrFail($id);
        $request->validate([
            'staff_name' => 'required',
            'staff_phone' => 'required|unique:staffs,staff_phone,' . $id,
            'email' => 'nullable|email',
        ]);
        $staff->update($request->all());
        return redirect()->route('staffs.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id) {
        Staff::destroy($id);
        return redirect()->route('staffs.index')->with('success', 'Xóa thành công');
    }
}

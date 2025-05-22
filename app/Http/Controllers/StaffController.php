<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
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
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        Staff::destroy($id);
        return redirect()->route('staffs.index')->with('success', 'Xóa thành công');
    }
}

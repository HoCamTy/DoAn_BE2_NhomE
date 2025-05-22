<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $limit = $request->input('limit', 5);
        $page = $request->input('page', 1);
        $start = ($page - 1) * $limit;

        $query = Customer::query();
        if ($search) {
            $query->where('customer_name', 'like', "%$search%");
        }

        $totalCustomers = $query->count();
        $customers = $query->offset($start)->limit($limit)->get();
        $totalPages = ceil($totalCustomers / $limit);

        return view('customers.index', compact('customers', 'search', 'limit', 'page', 'totalPages'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        Customer::create($validated);

        return redirect()->route('customers.index')->with('success', 'Thêm khách hàng thành công!');
    }
    public function showProfile()
{
    $customer = Auth::guard('customer')->user();

    if (!$customer) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập trước.');
    }

    return view('crud_user.profile', compact('customer'));
}
public function updateProfile(Request $request)
{
    $customer = Auth::guard('customer')->user();

    $request->validate([
        'email' => 'required|email|unique:customers,email,' . $customer->id,
        'phone' => 'nullable|string|max:20',
    ]);

    $customer->email = $request->input('email');
    $customer->phone = $request->input('phone');
    $customer->save();

    return redirect()->route('profile')->with('message', 'Thông tin đã được cập nhật thành công!');
}
    public function edit($id)
    {
        $customer = Customer::findOrFail($id); 
        return view('customers.edit', compact('customer')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->only('customer_name', 'phone', 'email', 'address'));

        return redirect()->route('customers.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Xóa thành công!');
    }
}

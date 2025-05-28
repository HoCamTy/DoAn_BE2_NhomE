<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Hiển thị danh sách thanh toán kèm tìm kiếm.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['customer', 'services']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('customer', function ($sub) use ($search) {
                    $sub->where('customer_name', 'like', '%' . $search . '%');
                })->orWhereHas('services', function ($sub) use ($search) {
                    $sub->where('service_name', 'like', '%' . $search . '%');
                });
            });
        }

        $payments = $query->orderByDesc('created_at')->paginate(5);

        return view('payments.index', compact('payments'));
    }

    /**
     * Hiển thị form tạo mới thanh toán.
     */
    public function create()
    {
        $customers = Customer::all();
        $services = Service::all();
        $staffs = Staff::all();
        return view('payments.create', compact('customers', 'services', 'staffs'));
    }

    /**
     * Lưu thanh toán mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'services'       => 'required|array',
            'staff_id'       => 'required|exists:staffs,id',
            'payment_method' => 'required|string',
            'total'          => 'required|numeric|min:0',
        ]);

        // Kiểm tra tổng tiền tính toán có khớp với người dùng nhập
        $calculatedTotal = Service::whereIn('id', $request->services)->sum('price');

        if (round($calculatedTotal, 2) !== round((float)$request->total, 2)) {
            return back()->withErrors(['total' => 'Tổng tiền không hợp lệ.']);
        }

        $payment = Payment::create([
            'customer_id'    => $request->customer_id,
            'total_amount'   => $request->total,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($request->services as $serviceId) {
            $payment->services()->attach($serviceId, [
                'staff_id' => $request->staff_id,
            ]);
        }

        return redirect()->route('payments.index')->with('success', 'Thanh toán thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa thanh toán.
     */
    public function edit($id)
    {
        $payment = Payment::with('services')->findOrFail($id);
        $customers = Customer::all();
        $services = Service::all();
        $staffs = Staff::all();

        return view('payments.edit', compact('payment', 'customers', 'services', 'staffs'));
    }

    /**
     * Cập nhật thanh toán.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'services'       => 'required|array',
            'staff_id'       => 'required|exists:staffs,id', // sửa 'staff' thành 'staffs'
            'payment_method' => 'required|string',
            'total'          => 'required|numeric|min:0',
        ]);

        $calculatedTotal = Service::whereIn('id', $request->services)->sum('price');

        if (round($calculatedTotal, 2) !== round((float)$request->total, 2)) {
            return back()->withErrors(['total' => 'Tổng tiền không hợp lệ.']);
        }

        $payment = Payment::findOrFail($id);
        $payment->update([
            'customer_id'    => $request->customer_id,
            'total_amount'   => $request->total,
            'payment_method' => $request->payment_method,
        ]);

        // Gán lại services + staff_id
        $syncData = [];
        foreach ($request->services as $serviceId) {
            $syncData[$serviceId] = ['staff_id' => $request->staff_id];
        }

        $payment->services()->sync($syncData);

        return redirect()->route('payments.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Xóa thanh toán.
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->services()->detach(); // xóa khỏi bảng pivot
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Đã xóa thanh toán');
    }
}

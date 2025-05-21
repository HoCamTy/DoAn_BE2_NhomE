<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Customer;
use App\Models\Service;
use App\Models\Staff;
use Illuminate\Http\Request;


class PaymentController extends Controller
{
   public function index(Request $request)
{
    $query = Payment::query()->with(['customer', 'services']);

    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->whereHas('customer', function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('services', function ($sub) use ($search) {
                $sub->where('name', 'like', '%' . $search . '%');
            });
        });
    }

   
    $payments = $query->orderBy('created_at', 'desc')->paginate(5);

    return view('payments.index', compact('payments'));
}

    public function create()
    {
        $customers = Customer::all();
        $services  = Service::all();
        $staffs    = Staff::all();

        return view('payments.create', compact('customers', 'services', 'staffs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'services'       => 'required|array',
            'staffs'         => 'required|array',
            'payment_method' => 'required|string',
            'total' => 'required|numeric|min:0',

        ]);

        // ✅ Kiểm tra tổng tiền từ server
        $calculatedTotal = Service::whereIn('id', $request->services)->sum('price');
        if ((int)$calculatedTotal !== (int)$request->total) {
            return back()->withErrors(['total' => 'Tổng tiền không hợp lệ.']);
        }

        $payment = Payment::create([
            'customer_id'    => $request->customer_id,
            'total_amount'   => $request->total,
            'payment_method' => $request->payment_method,
        ]);

        foreach ($request->services as $idx => $serviceId) {
            $payment->services()->attach($serviceId, [
                'staff_id' => $request->staffs[$idx] ?? null,
            ]);
        }

        return redirect()->route('payments.index')->with('success', 'Thanh toán thành công!');
    }

    public function edit($id)
    {
        $payment = Payment::with(['services' => function($q) {
            $q->with('staff');
        }])->findOrFail($id);

        $customers = Customer::all();
        $services  = Service::all();
        $staffs    = Staff::all();

        return view('payments.edit', compact('payment', 'customers', 'services', 'staffs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_id'    => 'required|exists:customers,id',
            'services'       => 'required|array',
            'staffs'         => 'required|array',
            'payment_method' => 'required|string',
            'total'          => 'required|numeric|min:0',
        ]);

        // ✅ Kiểm tra tổng tiền từ server
        $calculatedTotal = Service::whereIn('id', $request->services)->sum('price');
        if ((int)$calculatedTotal !== (int)$request->total) {
            return back()->withErrors(['total' => 'Tổng tiền không hợp lệ.']);
        }

        $payment = Payment::findOrFail($id);
        $payment->update([
            'customer_id'    => $request->customer_id,
            'total_amount'   => $request->total,
            'payment_method' => $request->payment_method,
        ]);

        $syncData = [];
        foreach ($request->services as $idx => $serviceId) {
            $syncData[$serviceId] = ['staff_id' => $request->staffs[$idx] ?? null];
        }

        $payment->services()->sync($syncData);

        return redirect()->route('payments.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->services()->detach();
        $payment->delete();

        return redirect()->route('payments.index')->with('success', 'Đã xóa thanh toán');
    }
}

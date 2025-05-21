<?php

namespace App\Http\Controllers;

use App\Models\CustomerRating;
use App\Models\Customer; // nhớ import model Customer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRatingController extends Controller
{
    // Trang form tạo đánh giá, truyền danh sách khách hàng sang view
    public function create()
    {
        $customers = Customer::all();
        return view('ratings.create', compact('customers'));
    }

    // Trang danh sách đánh giá
    public function index()
    {
        $ratings = CustomerRating::with('customer')->latest()->paginate(3);
    return view('ratings.index', compact('ratings'));
    }

    // Xử lý lưu đánh giá mới
    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id', // thêm validate customer_id
            'service_rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string|max:1000',
        ]);

        CustomerRating::create([
            'customer_id' => $request->customer_id,
            'service_rating' => $request->service_rating,
            'comments' => $request->comments,
        ]);

        return redirect()->route('ratings.index')->with('success', 'Cảm ơn bạn đã đánh giá!');
    }
}


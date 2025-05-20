<?php

namespace App\Http\Controllers;

use App\Models\CustomerRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerRatingController extends Controller
{
    public function index()
    {
        $ratings = CustomerRating::with('customer')->latest()->get();
        return view('ratings.index', compact('ratings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string|max:1000',
        ]);

        CustomerRating::create([
            'customer_id' => Auth::guard('customer')->id(),
            'service_rating' => $request->service_rating,
            'comments' => $request->comments,
        ]);

        return redirect()->back()->with('success', 'Cảm ơn bạn đã đánh giá dịch vụ!');
    }
}

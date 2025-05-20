<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('categories');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('service_name', 'like', "%{$search}%");
        }

        $perPage = $request->get('perPage', 10);
        $services = $query->paginate($perPage);

        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'service_duration' => 'required|integer|min:0',
            'categories' => 'required|array'
        ]);

        $service = Service::create([
            'service_name' => $validated['service_name'],
            'price' => $validated['price'],
            'service_duration' => $validated['service_duration']
        ]);

        $service->categories()->attach($validated['categories']);

        return redirect()->route('services.index')
            ->with('success', 'Dịch vụ đã được tạo thành công.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $categories = Category::all();
        return view('services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'service_name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'service_duration' => 'required|integer|min:0',
            'categories' => 'required|array|exists:categories,id'
        ]);

        $service->update([
            'service_name' => $validated['service_name'],
            'price' => $validated['price'],
            'service_duration' => $validated['service_duration']
        ]);

        $service->categories()->sync($validated['categories']);

        return redirect()
            ->route('services.index')
            ->with('success', 'Dịch vụ đã được cập nhật thành công.');
    }

    public function destroy(Service $service)
    {
        $service->categories()->detach();
        $service->delete();

        return redirect()->route('services.index')
            ->with('success', 'Dịch vụ đã được xóa thành công.');
    }
}

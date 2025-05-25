<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
   public function index(Request $request)
    {
        // Build the query
        $query = Appointment::with(['customer', 'services'])
            ->latest();

        // Filter by date if provided
        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date);
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by service if provided
        if ($request->filled('service_id')) {
            $query->whereHas('services', function ($q) use ($request) {
                $q->where('services.id', $request->service_id);
            });
        }

        // Get the per page value from request or use default
        $perPage = $request->input('perPage', 10);

        // Get paginated results
        $appointments = $query->paginate($perPage)
            ->withQueryString(); // Keeps other query parameters in pagination links

        // Get all services for filter dropdown
        $services = Service::all();

        return view('appointments.index', compact('appointments', 'services'));
    }

 public function create()
    {
        $services = Service::all();
        return view('appointments.create', compact('services'));
    }

    public function store(Request $request)
    {
        // Validate all input fields
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'services' => 'required|array|exists:services,id',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Check if customer exists or create new one
            $customer = Customer::firstOrCreate(
                ['phone' => $validated['phone']],
                [
                    'customer_name' => $validated['customer_name'],
                    'email' => $validated['email'],
                    'address' => $validated['address'],
                ]
            );

            // Combine date and time
            $appointmentDateTime = Carbon::parse($validated['appointment_date'])
                ->setTimeFromTimeString($validated['appointment_time']);

            // Create appointment
            $appointment = Appointment::create([
                'customer_id' => $customer->id,
                'appointment_date' => $appointmentDateTime,
                'status' => 'pending',
                'notes' => $validated['notes']
            ]);

            // Attach services
            $appointment->services()->attach($validated['services']);

            DB::commit();

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Đặt lịch thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function edit(Appointment $appointment)
    {
        $services = Service::all();
        $appointment->load('customer', 'services');

        return view('appointments.edit', compact('appointment', 'services'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'email' => 'nullable|email|max:100',
            'address' => 'nullable|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'services' => 'required|array|exists:services,id',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Update customer information
            $appointment->customer->update([
                'customer_name' => $validated['customer_name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address']
            ]);

            // Combine date and time
            $appointmentDateTime = Carbon::parse($validated['appointment_date'])
                ->setTimeFromTimeString($validated['appointment_time']);

            // Update appointment
            $appointment->update([
                'appointment_date' => $appointmentDateTime,
                'status' => $validated['status'],
                'notes' => $validated['notes']
            ]);

            // Sync services
            $appointment->services()->sync($validated['services']);

            DB::commit();

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Cập nhật lịch hẹn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Có lỗi xảy ra khi cập nhật lịch hẹn: ' . $e->getMessage()]);
        }
    }

    public function destroy(Appointment $appointment)
    {
        try {
            DB::beginTransaction();

            // Delete related services first
            $appointment->services()->detach();

            // Then delete the appointment
            $appointment->delete();

            DB::commit();

            return redirect()
                ->route('appointments.index')
                ->with('success', 'Xóa lịch hẹn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Có lỗi xảy ra khi xóa lịch hẹn']);
        }
    }

    public function myAppointments()
    {
        // Get customer ID from the authenticated session
        $customerId = Auth::guard('customer')->id();

        if (!$customerId) {
            return redirect()->route('login')
                ->with('error', 'Vui lòng đăng nhập để xem lịch hẹn');
        }

        // Find the customer by ID and get their appointments
        $customer = Customer::findOrFail($customerId);
        $appointments = $customer->appointments()
            ->with('services')
            ->latest()
            ->paginate(10);

        return view('customer.appointments', compact('appointments'));
    }

    public function cancelAppointment(Appointment $appointment)
    {
        // Check if appointment belongs to logged in customer
        if ($appointment->customer_id !== Auth::guard('customer')->id()) {
            return back()->with('error', 'Bạn không có quyền hủy lịch hẹn này');
        }

        // Check if appointment can be cancelled
        if ($appointment->status === 'completed' || $appointment->status === 'cancelled') {
            return back()->with('error', 'Không thể hủy lịch hẹn này');
        }

        $appointment->update(['status' => 'cancelled']);

        return back()->with('success', 'Đã hủy lịch hẹn thành công');
    }

    public function customerCreate()
    {
        $customer = Auth::guard('customer')->user();
        $services = Service::all();

        return view('customer.create', compact('customer', 'services'));
    }

    public function customerStore(Request $request)
    {
        // Get the authenticated customer
        $customer = Customer::findOrFail(Auth::guard('customer')->id());

        // Validate request
        $validated = $request->validate([
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'services' => 'required|array|exists:services,id',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            // Combine date and time
            $appointmentDateTime = Carbon::parse($validated['appointment_date'])
                ->setTimeFromTimeString($validated['appointment_time']);

            // Create appointment
            $appointment = Appointment::create([
                'customer_id' => $customer->id,
                'appointment_date' => $appointmentDateTime,
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null
            ]);

            // Attach services
            $appointment->services()->attach($validated['services']);

            DB::commit();

            return redirect()
                ->route('customer.appointments')
                ->with('success', 'Đặt lịch thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->withErrors(['error' => 'Có lỗi xảy ra khi đặt lịch: ' . $e->getMessage()]);
        }
    }
}

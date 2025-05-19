<?php


class AppointmentController extends Controller
{

    public function create()
    {
        $services = Service::all();
        return view('appointments.create', compact('services'));
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

}
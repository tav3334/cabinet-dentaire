<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Appointment::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by patient
        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('appointment_date', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('appointment_date', '<=', $request->date_to);
        }

        // Include trashed if requested
        if ($request->boolean('include_trashed')) {
            $query->withTrashed();
        }

        // Include relationships if requested
        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $query->with($includes);
        }

        // Pagination
        $perPage = $request->get('per_page', 15);
        $appointments = $query->latest('appointment_date')->paginate($perPage);

        return AppointmentResource::collection($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'service_id' => 'required|exists:services,id',
            'name' => 'required_without:patient_id|string|max:255',
            'phone' => 'required_without:patient_id|string|max:20',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'duration' => 'nullable|integer|min:15',
            'message' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,canceled,completed',
        ]);

        $appointment = Appointment::create($validated);
        $appointment->load(['patient', 'service']);

        return new AppointmentResource($appointment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Appointment $appointment)
    {
        // Include relationships if requested
        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $appointment->load($includes);
        }

        return new AppointmentResource($appointment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'nullable|exists:patients,id',
            'service_id' => 'sometimes|required|exists:services,id',
            'name' => 'sometimes|required|string|max:255',
            'phone' => 'sometimes|required|string|max:20',
            'appointment_date' => 'sometimes|required|date',
            'appointment_time' => 'sometimes|required|date_format:H:i',
            'duration' => 'nullable|integer|min:15',
            'message' => 'nullable|string',
            'status' => 'nullable|in:pending,confirmed,canceled,completed',
        ]);

        $appointment->update($validated);
        $appointment->load(['patient', 'service']);

        return new AppointmentResource($appointment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return response()->json([
            'message' => 'Appointment deleted successfully',
        ]);
    }

    /**
     * Restore a soft-deleted appointment
     */
    public function restore($id)
    {
        $appointment = Appointment::withTrashed()->findOrFail($id);
        $appointment->restore();

        return new AppointmentResource($appointment);
    }
}

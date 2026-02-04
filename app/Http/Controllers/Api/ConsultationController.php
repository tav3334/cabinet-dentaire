<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultationResource;
use App\Models\Consultation;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::query();

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('practitioner_id')) {
            $query->where('practitioner_id', $request->practitioner_id);
        }

        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $query->with($includes);
        }

        $perPage = $request->get('per_page', 15);
        $consultations = $query->latest('consultation_date')->paginate($perPage);

        return ConsultationResource::collection($consultations);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable|string',
            'type' => 'required|in:first_visit,follow_up,emergency,control,treatment',
            'chief_complaint' => 'nullable|string',
            'clinical_examination' => 'nullable|string',
            'oral_hygiene' => 'nullable|string',
            'periodontal_status' => 'nullable|string',
            'dental_chart' => 'nullable|array',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'next_appointment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'practitioner_id' => 'nullable|exists:users,id',
        ]);

        $consultation = Consultation::create($validated);
        $consultation->load(['patient', 'practitioner']);

        return new ConsultationResource($consultation);
    }

    public function show(Request $request, Consultation $consultation)
    {
        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $consultation->load($includes);
        }

        return new ConsultationResource($consultation);
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'patient_id' => 'sometimes|required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_date' => 'sometimes|required|date',
            'consultation_time' => 'nullable|string',
            'type' => 'sometimes|required|in:first_visit,follow_up,emergency,control,treatment',
            'chief_complaint' => 'nullable|string',
            'clinical_examination' => 'nullable|string',
            'oral_hygiene' => 'nullable|string',
            'periodontal_status' => 'nullable|string',
            'dental_chart' => 'nullable|array',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'next_appointment_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'practitioner_id' => 'nullable|exists:users,id',
        ]);

        $consultation->update($validated);
        $consultation->load(['patient', 'practitioner']);

        return new ConsultationResource($consultation);
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return response()->json([
            'message' => 'Consultation deleted successfully',
        ]);
    }
}

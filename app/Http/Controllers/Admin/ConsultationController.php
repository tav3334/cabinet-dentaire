<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = Consultation::with(['patient', 'practitioner']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $consultations = $query->latest('consultation_date')->paginate(15);
        $patients = Patient::orderBy('first_name')->get();

        return view('admin.consultations.index', compact('consultations', 'patients'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $appointments = Appointment::with('patient')->where('status', 'confirmed')->orderBy('appointment_date', 'desc')->get();

        return view('admin.consultations.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable|date_format:H:i',
            'type' => 'required|in:first_visit,follow_up,emergency,control,treatment,other',
            'chief_complaint' => 'nullable|string',
            'clinical_examination' => 'nullable|string',
            'oral_hygiene' => 'nullable|string',
            'periodontal_status' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'next_appointment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $validated['practitioner_id'] = Auth::id();

        Consultation::create($validated);

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation créée avec succès.');
    }

    public function show(Consultation $consultation)
    {
        $consultation->load(['patient', 'practitioner', 'medicalFiles']);

        return view('admin.consultations.show', compact('consultation'));
    }

    public function edit(Consultation $consultation)
    {
        $patients = Patient::orderBy('first_name')->get();
        $appointments = Appointment::with('patient')->where('status', 'confirmed')->orderBy('appointment_date', 'desc')->get();

        return view('admin.consultations.edit', compact('consultation', 'patients', 'appointments'));
    }

    public function update(Request $request, Consultation $consultation)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'consultation_date' => 'required|date',
            'consultation_time' => 'nullable|date_format:H:i',
            'type' => 'required|in:first_visit,follow_up,emergency,control,treatment,other',
            'chief_complaint' => 'nullable|string',
            'clinical_examination' => 'nullable|string',
            'oral_hygiene' => 'nullable|string',
            'periodontal_status' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'prescriptions' => 'nullable|string',
            'recommendations' => 'nullable|string',
            'next_appointment_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $consultation->update($validated);

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation mise à jour avec succès.');
    }

    public function destroy(Consultation $consultation)
    {
        $consultation->delete();

        return redirect()->route('admin.consultations.index')->with('success', 'Consultation supprimée avec succès.');
    }
}

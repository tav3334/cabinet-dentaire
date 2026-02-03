<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Treatment;
use App\Models\Patient;
use App\Models\Appointment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Treatment::with(['patient', 'appointment']);

        // Filtrer par patient
        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrer par catégorie
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $treatments = $query->latest()->paginate(15);
        $patients = Patient::orderBy('first_name')->get();

        return view('admin.treatments.index', compact('treatments', 'patients'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $appointments = Appointment::with('patient')->where('status', 'confirmed')->orderBy('appointment_date', 'desc')->get();

        return view('admin.treatments.create', compact('patients', 'appointments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tooth_number' => 'nullable|string|max:10',
            'category' => 'required|in:consultation,preventive,restorative,endodontic,periodontic,surgery,prosthetic,orthodontic,cosmetic,emergency,other',
            'status' => 'required|in:planned,in_progress,completed,cancelled,on_hold',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'planned_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'sessions_required' => 'required|integer|min:1',
            'sessions_completed' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        Treatment::create($validated);

        return redirect()->route('admin.treatments.index')->with('success', 'Traitement créé avec succès.');
    }

    public function show(Treatment $treatment)
    {
        $treatment->load(['patient', 'appointment', 'medicalFiles']);

        return view('admin.treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment)
    {
        $patients = Patient::orderBy('first_name')->get();
        $appointments = Appointment::with('patient')->where('status', 'confirmed')->orderBy('appointment_date', 'desc')->get();

        return view('admin.treatments.edit', compact('treatment', 'patients', 'appointments'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tooth_number' => 'nullable|string|max:10',
            'category' => 'required|in:consultation,preventive,restorative,endodontic,periodontic,surgery,prosthetic,orthodontic,cosmetic,emergency,other',
            'status' => 'required|in:planned,in_progress,completed,cancelled,on_hold',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'planned_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'sessions_required' => 'required|integer|min:1',
            'sessions_completed' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $treatment->update($validated);

        return redirect()->route('admin.treatments.index')->with('success', 'Traitement mis à jour avec succès.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()->route('admin.treatments.index')->with('success', 'Traitement supprimé avec succès.');
    }
}

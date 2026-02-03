<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->withCount('appointments')
                         ->orderBy('created_at', 'desc')
                         ->paginate(15);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Patient::create($validated);

        return redirect()->route('admin.patients.index')
                         ->with('success', 'Patient ajouté avec succès.');
    }

    public function show(Patient $patient)
    {
        $patient->load(['appointments' => function($query) {
            $query->with('service')->orderBy('appointment_date', 'desc');
        }]);

        return view('admin.patients.show', compact('patient'));
    }

    public function medicalRecord(Patient $patient)
    {
        $patient->load([
            'appointments' => function($query) {
                $query->with('service')->orderBy('appointment_date', 'desc')->limit(10);
            },
            'treatments' => function($query) {
                $query->orderBy('created_at', 'desc');
            },
            'consultations' => function($query) {
                $query->with('practitioner')->orderBy('consultation_date', 'desc');
            },
            'medicalFiles' => function($query) {
                $query->orderBy('document_date', 'desc');
            }
        ]);

        // Statistiques
        $stats = [
            'total_appointments' => $patient->appointments()->count(),
            'total_treatments' => $patient->treatments()->count(),
            'active_treatments' => $patient->treatments()->whereIn('status', ['planned', 'in_progress'])->count(),
            'completed_treatments' => $patient->treatments()->where('status', 'completed')->count(),
            'total_consultations' => $patient->consultations()->count(),
            'total_files' => $patient->medicalFiles()->count(),
        ];

        return view('admin.patients.medical-record', compact('patient', 'stats'));
    }

    public function edit(Patient $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients,email,' . $patient->id,
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'medical_history' => 'nullable|string',
            'allergies' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $patient->update($validated);

        return redirect()->route('admin.patients.index')
                         ->with('success', 'Patient modifié avec succès.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')
                         ->with('success', 'Patient supprimé avec succès.');
    }
}

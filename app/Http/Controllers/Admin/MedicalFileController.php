<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MedicalFile;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicalFileController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalFile::with(['patient', 'consultation', 'treatment']);

        if ($request->filled('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $files = $query->latest()->paginate(15);
        $patients = Patient::orderBy('first_name')->get();

        return view('admin.medical-files.index', compact('files', 'patients'));
    }

    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();
        $consultations = Consultation::with('patient')->latest()->get();
        $treatments = Treatment::with('patient')->latest()->get();

        return view('admin.medical-files.create', compact('patients', 'consultations', 'treatments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'consultation_id' => 'nullable|exists:consultations,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:xray,scan,photo,document,prescription,report,consent,lab_result,other',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png,gif,doc,docx|max:10240', // 10MB max
            'document_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('medical-files', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_extension'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $validated['uploaded_by'] = Auth::id();

        MedicalFile::create($validated);

        return redirect()->route('admin.medical-files.index')->with('success', 'Fichier médical ajouté avec succès.');
    }

    public function show(MedicalFile $medicalFile)
    {
        $medicalFile->load(['patient', 'consultation', 'treatment', 'uploader']);

        return view('admin.medical-files.show', compact('medicalFile'));
    }

    public function edit(MedicalFile $medicalFile)
    {
        $patients = Patient::orderBy('first_name')->get();
        $consultations = Consultation::with('patient')->latest()->get();
        $treatments = Treatment::with('patient')->latest()->get();

        return view('admin.medical-files.edit', compact('medicalFile', 'patients', 'consultations', 'treatments'));
    }

    public function update(Request $request, MedicalFile $medicalFile)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'consultation_id' => 'nullable|exists:consultations,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:xray,scan,photo,document,prescription,report,consent,lab_result,other',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png,gif,doc,docx|max:10240',
            'document_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            // Supprimer l'ancien fichier
            if ($medicalFile->file_path && Storage::disk('public')->exists($medicalFile->file_path)) {
                Storage::disk('public')->delete($medicalFile->file_path);
            }

            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('medical-files', $fileName, 'public');

            $validated['file_path'] = $filePath;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_extension'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
        }

        $medicalFile->update($validated);

        return redirect()->route('admin.medical-files.index')->with('success', 'Fichier médical mis à jour avec succès.');
    }

    public function destroy(MedicalFile $medicalFile)
    {
        // Supprimer le fichier du stockage
        if ($medicalFile->file_path && Storage::disk('public')->exists($medicalFile->file_path)) {
            Storage::disk('public')->delete($medicalFile->file_path);
        }

        $medicalFile->delete();

        return redirect()->route('admin.medical-files.index')->with('success', 'Fichier médical supprimé avec succès.');
    }

    public function download(MedicalFile $medicalFile)
    {
        if (!Storage::disk('public')->exists($medicalFile->file_path)) {
            abort(404, 'Fichier non trouvé.');
        }

        return Storage::disk('public')->download($medicalFile->file_path, $medicalFile->file_name);
    }
}

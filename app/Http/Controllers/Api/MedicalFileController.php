<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicalFileResource;
use App\Models\MedicalFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalFileController extends Controller
{
    public function index(Request $request)
    {
        $query = MedicalFile::query();

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('consultation_id')) {
            $query->where('consultation_id', $request->consultation_id);
        }

        if ($request->has('treatment_id')) {
            $query->where('treatment_id', $request->treatment_id);
        }

        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $query->with($includes);
        }

        $perPage = $request->get('per_page', 15);
        $files = $query->latest()->paginate($perPage);

        return MedicalFileResource::collection($files);
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
            'file' => 'required|file|max:10240',
            'document_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('medical-files', 'public');

            $validated['file_path'] = $path;
            $validated['file_name'] = $file->getClientOriginalName();
            $validated['file_extension'] = $file->getClientOriginalExtension();
            $validated['file_size'] = $file->getSize();
            $validated['mime_type'] = $file->getMimeType();
            $validated['uploaded_by'] = $request->user()->id;
        }

        unset($validated['file']);
        $medicalFile = MedicalFile::create($validated);
        $medicalFile->load(['patient', 'uploader']);

        return new MedicalFileResource($medicalFile);
    }

    public function show(Request $request, MedicalFile $medicalFile)
    {
        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $medicalFile->load($includes);
        }

        return new MedicalFileResource($medicalFile);
    }

    public function update(Request $request, MedicalFile $medicalFile)
    {
        $validated = $request->validate([
            'patient_id' => 'sometimes|required|exists:patients,id',
            'consultation_id' => 'nullable|exists:consultations,id',
            'treatment_id' => 'nullable|exists:treatments,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'sometimes|required|in:xray,scan,photo,document,prescription,report,consent,lab_result,other',
            'document_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $medicalFile->update($validated);

        return new MedicalFileResource($medicalFile);
    }

    public function destroy(MedicalFile $medicalFile)
    {
        // Delete file from storage
        if ($medicalFile->file_path) {
            Storage::disk('public')->delete($medicalFile->file_path);
        }

        $medicalFile->delete();

        return response()->json([
            'message' => 'Medical file deleted successfully',
        ]);
    }

    public function download(MedicalFile $medicalFile)
    {
        if (!Storage::disk('public')->exists($medicalFile->file_path)) {
            return response()->json([
                'message' => 'File not found',
            ], 404);
        }

        return Storage::disk('public')->download(
            $medicalFile->file_path,
            $medicalFile->file_name
        );
    }
}

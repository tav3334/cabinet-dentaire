<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TreatmentResource;
use App\Models\Treatment;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Treatment::query();

        if ($request->has('patient_id')) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $query->with($includes);
        }

        $perPage = $request->get('per_page', 15);
        $treatments = $query->latest()->paginate($perPage);

        return TreatmentResource::collection($treatments);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'tooth_number' => 'nullable|string|max:10',
            'category' => 'required|in:consultation,preventive,restorative,endodontic,periodontic,surgery,prosthetic,orthodontic,cosmetic,emergency',
            'status' => 'nullable|in:planned,in_progress,completed,cancelled,on_hold',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'planned_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'sessions_required' => 'nullable|integer|min:1',
            'sessions_completed' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $treatment = Treatment::create($validated);
        $treatment->load(['patient', 'appointment']);

        return new TreatmentResource($treatment);
    }

    public function show(Request $request, Treatment $treatment)
    {
        if ($request->has('include')) {
            $includes = explode(',', $request->include);
            $treatment->load($includes);
        }

        return new TreatmentResource($treatment);
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'patient_id' => 'sometimes|required|exists:patients,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'tooth_number' => 'nullable|string|max:10',
            'category' => 'sometimes|required|in:consultation,preventive,restorative,endodontic,periodontic,surgery,prosthetic,orthodontic,cosmetic,emergency',
            'status' => 'nullable|in:planned,in_progress,completed,cancelled,on_hold',
            'estimated_cost' => 'nullable|numeric|min:0',
            'actual_cost' => 'nullable|numeric|min:0',
            'planned_date' => 'nullable|date',
            'completed_date' => 'nullable|date',
            'sessions_required' => 'nullable|integer|min:1',
            'sessions_completed' => 'nullable|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $treatment->update($validated);
        $treatment->load(['patient', 'appointment']);

        return new TreatmentResource($treatment);
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return response()->json([
            'message' => 'Treatment deleted successfully',
        ]);
    }
}

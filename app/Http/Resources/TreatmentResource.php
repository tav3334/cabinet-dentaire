<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TreatmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'appointment_id' => $this->appointment_id,
            'title' => $this->title,
            'description' => $this->description,
            'tooth_number' => $this->tooth_number,
            'category' => $this->category,
            'category_label' => $this->category_label,
            'status' => $this->status,
            'status_label' => $this->status_label,
            'estimated_cost' => $this->estimated_cost,
            'actual_cost' => $this->actual_cost,
            'planned_date' => $this->planned_date?->format('Y-m-d'),
            'completed_date' => $this->completed_date?->format('Y-m-d'),
            'sessions_required' => $this->sessions_required,
            'sessions_completed' => $this->sessions_completed,
            'progress_percentage' => $this->progress_percentage,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Relationships
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'appointment' => new AppointmentResource($this->whenLoaded('appointment')),
            'medical_files' => MedicalFileResource::collection($this->whenLoaded('medicalFiles')),
        ];
    }
}

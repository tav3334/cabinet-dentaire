<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultationResource extends JsonResource
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
            'consultation_date' => $this->consultation_date?->format('Y-m-d'),
            'consultation_time' => $this->consultation_time,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'chief_complaint' => $this->chief_complaint,
            'clinical_examination' => $this->clinical_examination,
            'oral_hygiene' => $this->oral_hygiene,
            'periodontal_status' => $this->periodontal_status,
            'dental_chart' => $this->dental_chart,
            'diagnosis' => $this->diagnosis,
            'treatment_plan' => $this->treatment_plan,
            'prescriptions' => $this->prescriptions,
            'recommendations' => $this->recommendations,
            'next_appointment_date' => $this->next_appointment_date?->format('Y-m-d'),
            'notes' => $this->notes,
            'practitioner_id' => $this->practitioner_id,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Relationships
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'appointment' => new AppointmentResource($this->whenLoaded('appointment')),
            'practitioner' => new UserResource($this->whenLoaded('practitioner')),
            'medical_files' => MedicalFileResource::collection($this->whenLoaded('medicalFiles')),
        ];
    }
}

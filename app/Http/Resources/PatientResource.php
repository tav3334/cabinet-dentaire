<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth?->format('Y-m-d'),
            'age' => $this->age,
            'gender' => $this->gender,
            'address' => $this->address,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'medical_history' => $this->medical_history,
            'allergies' => $this->allergies,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Relationships (loaded only when requested)
            'appointments' => AppointmentResource::collection($this->whenLoaded('appointments')),
            'treatments' => TreatmentResource::collection($this->whenLoaded('treatments')),
            'consultations' => ConsultationResource::collection($this->whenLoaded('consultations')),
            'medical_files' => MedicalFileResource::collection($this->whenLoaded('medicalFiles')),
        ];
    }
}

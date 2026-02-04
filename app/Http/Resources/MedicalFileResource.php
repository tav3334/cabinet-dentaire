<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalFileResource extends JsonResource
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
            'consultation_id' => $this->consultation_id,
            'treatment_id' => $this->treatment_id,
            'title' => $this->title,
            'description' => $this->description,
            'type' => $this->type,
            'type_label' => $this->type_label,
            'file_path' => $this->file_path,
            'file_name' => $this->file_name,
            'file_extension' => $this->file_extension,
            'file_size' => $this->file_size,
            'file_size_formatted' => $this->file_size_formatted,
            'file_url' => $this->file_url,
            'mime_type' => $this->mime_type,
            'document_date' => $this->document_date?->format('Y-m-d'),
            'uploaded_by' => $this->uploaded_by,
            'notes' => $this->notes,
            'is_image' => $this->isImage(),
            'is_pdf' => $this->isPdf(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),

            // Relationships
            'patient' => new PatientResource($this->whenLoaded('patient')),
            'consultation' => new ConsultationResource($this->whenLoaded('consultation')),
            'treatment' => new TreatmentResource($this->whenLoaded('treatment')),
            'uploader' => new UserResource($this->whenLoaded('uploader')),
        ];
    }
}

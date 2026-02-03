<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Consultation extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'consultation_date',
        'consultation_time',
        'type',
        'chief_complaint',
        'clinical_examination',
        'oral_hygiene',
        'periodontal_status',
        'dental_chart',
        'diagnosis',
        'treatment_plan',
        'prescriptions',
        'recommendations',
        'next_appointment_date',
        'notes',
        'practitioner_id',
    ];

    protected $casts = [
        'consultation_date' => 'date',
        'next_appointment_date' => 'date',
        'dental_chart' => 'array', // Pour stocker des données JSON
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function practitioner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'practitioner_id');
    }

    public function medicalFiles(): HasMany
    {
        return $this->hasMany(MedicalFile::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'first_visit' => 'Première visite',
            'follow_up' => 'Suivi',
            'emergency' => 'Urgence',
            'control' => 'Contrôle',
            'treatment' => 'Traitement',
            default => 'Autre',
        };
    }
}

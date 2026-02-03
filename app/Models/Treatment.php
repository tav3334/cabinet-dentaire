<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Treatment extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'title',
        'description',
        'tooth_number',
        'category',
        'status',
        'estimated_cost',
        'actual_cost',
        'planned_date',
        'completed_date',
        'sessions_required',
        'sessions_completed',
        'notes',
    ];

    protected $casts = [
        'planned_date' => 'date',
        'completed_date' => 'date',
        'estimated_cost' => 'decimal:2',
        'actual_cost' => 'decimal:2',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function medicalFiles(): HasMany
    {
        return $this->hasMany(MedicalFile::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'planned' => 'Planifié',
            'in_progress' => 'En cours',
            'completed' => 'Terminé',
            'cancelled' => 'Annulé',
            'on_hold' => 'En attente',
            default => 'Inconnu',
        };
    }

    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'consultation' => 'Consultation',
            'preventive' => 'Préventif',
            'restorative' => 'Restauration',
            'endodontic' => 'Endodontie',
            'periodontic' => 'Parodontie',
            'surgery' => 'Chirurgie',
            'prosthetic' => 'Prothèse',
            'orthodontic' => 'Orthodontie',
            'cosmetic' => 'Esthétique',
            'emergency' => 'Urgence',
            default => 'Autre',
        };
    }

    public function getProgressPercentageAttribute(): float
    {
        if ($this->sessions_required <= 0) {
            return 0;
        }
        return round(($this->sessions_completed / $this->sessions_required) * 100, 1);
    }
}

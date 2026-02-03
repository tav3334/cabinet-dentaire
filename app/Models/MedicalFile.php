<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class MedicalFile extends Model
{
    protected $fillable = [
        'patient_id',
        'consultation_id',
        'treatment_id',
        'title',
        'description',
        'type',
        'file_path',
        'file_name',
        'file_extension',
        'file_size',
        'mime_type',
        'document_date',
        'uploaded_by',
        'notes',
    ];

    protected $casts = [
        'document_date' => 'date',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function consultation(): BelongsTo
    {
        return $this->belongsTo(Consultation::class);
    }

    public function treatment(): BelongsTo
    {
        return $this->belongsTo(Treatment::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'xray' => 'Radiographie',
            'scan' => 'Scanner',
            'photo' => 'Photo',
            'document' => 'Document',
            'prescription' => 'Ordonnance',
            'report' => 'Rapport',
            'consent' => 'Consentement',
            'lab_result' => 'Résultat labo',
            default => 'Autre',
        };
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) {
            return 'N/A';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = $this->file_size;
        $i = 0;

        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getFileUrlAttribute(): string
    {
        return Storage::url($this->file_path);
    }

    public function isImage(): bool
    {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
        return in_array(strtolower($this->file_extension), $imageExtensions);
    }

    public function isPdf(): bool
    {
        return strtolower($this->file_extension) === 'pdf';
    }
}

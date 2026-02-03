@extends('admin.layouts.admin')

@section('title', 'Détails de la consultation')
@section('page-title', 'Consultation')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.consultations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour
    </a>
</div>

<div class="row">
    <div class="col-lg-10 mx-auto">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">
                    <i class="bi bi-clipboard2-pulse me-2"></i>
                    Consultation - {{ $consultation->patient->full_name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Date:</strong><br>
                        {{ $consultation->consultation_date->format('d/m/Y') }}
                        @if($consultation->consultation_time)
                            à {{ $consultation->consultation_time->format('H:i') }}
                        @endif
                    </div>
                    <div class="col-md-4">
                        <strong>Type:</strong><br>
                        <span class="badge bg-info">{{ $consultation->type_label }}</span>
                    </div>
                    <div class="col-md-4">
                        <strong>Praticien:</strong><br>
                        {{ $consultation->practitioner->name ?? '-' }}
                    </div>
                </div>

                @if($consultation->chief_complaint)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-chat-left-text me-2"></i>Motif de consultation</h6>
                        <p class="ms-4">{{ $consultation->chief_complaint }}</p>
                    </div>
                @endif

                @if($consultation->clinical_examination || $consultation->oral_hygiene || $consultation->periodontal_status)
                    <h6 class="text-primary mt-4"><i class="bi bi-clipboard-check me-2"></i>Examen Clinique</h6>
                    <div class="ms-4">
                        @if($consultation->clinical_examination)
                            <div class="mb-3">
                                <strong>Examen:</strong>
                                <p>{{ $consultation->clinical_examination }}</p>
                            </div>
                        @endif
                        @if($consultation->oral_hygiene)
                            <div class="mb-3">
                                <strong>Hygiène bucco-dentaire:</strong>
                                <p>{{ $consultation->oral_hygiene }}</p>
                            </div>
                        @endif
                        @if($consultation->periodontal_status)
                            <div class="mb-3">
                                <strong>État parodontal:</strong>
                                <p>{{ $consultation->periodontal_status }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if($consultation->diagnosis)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-file-medical me-2"></i>Diagnostic</h6>
                        <p class="ms-4">{{ $consultation->diagnosis }}</p>
                    </div>
                @endif

                @if($consultation->treatment_plan)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-list-check me-2"></i>Plan de traitement</h6>
                        <p class="ms-4">{{ $consultation->treatment_plan }}</p>
                    </div>
                @endif

                @if($consultation->prescriptions)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-prescription2 me-2"></i>Prescriptions</h6>
                        <p class="ms-4">{{ $consultation->prescriptions }}</p>
                    </div>
                @endif

                @if($consultation->recommendations)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-lightbulb me-2"></i>Recommandations</h6>
                        <p class="ms-4">{{ $consultation->recommendations }}</p>
                    </div>
                @endif

                @if($consultation->next_appointment_date)
                    <div class="alert alert-info">
                        <i class="bi bi-calendar-check me-2"></i>
                        <strong>Prochain rendez-vous:</strong> {{ $consultation->next_appointment_date->format('d/m/Y') }}
                    </div>
                @endif

                @if($consultation->notes)
                    <div class="mb-4">
                        <h6 class="text-primary"><i class="bi bi-sticky me-2"></i>Notes</h6>
                        <p class="ms-4">{{ $consultation->notes }}</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.consultations.edit', $consultation) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.consultations.destroy', $consultation) }}" method="POST" onsubmit="return confirm('Supprimer cette consultation ?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

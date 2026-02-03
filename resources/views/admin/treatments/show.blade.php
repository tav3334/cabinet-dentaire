@extends('admin.layouts.admin')

@section('title', 'Détails du traitement')
@section('page-title', 'Détails du traitement')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.treatments.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-1"></i>Retour à la liste
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">{{ $treatment->title }}</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Patient:</strong><br>
                        <a href="{{ route('admin.patients.show', $treatment->patient) }}">
                            {{ $treatment->patient->full_name }}
                        </a>
                    </div>
                    <div class="col-md-6">
                        <strong>Catégorie:</strong><br>
                        <span class="badge bg-secondary">{{ $treatment->category_label }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Statut:</strong><br>
                        <span class="badge badge-{{ $treatment->status === 'completed' ? 'success' : ($treatment->status === 'in_progress' ? 'warning' : 'primary') }}">
                            {{ $treatment->status_label }}
                        </span>
                    </div>
                    <div class="col-md-6">
                        <strong>Numéro de dent:</strong><br>
                        {{ $treatment->tooth_number ?? '-' }}
                    </div>
                </div>

                @if($treatment->description)
                    <div class="mb-3">
                        <strong>Description:</strong>
                        <p class="mt-2">{{ $treatment->description }}</p>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Date planifiée:</strong><br>
                        {{ $treatment->planned_date ? $treatment->planned_date->format('d/m/Y') : '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Date de complétion:</strong><br>
                        {{ $treatment->completed_date ? $treatment->completed_date->format('d/m/Y') : '-' }}
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Progression:</strong>
                    <div class="progress mt-2" style="height: 30px;">
                        <div class="progress-bar" role="progressbar" style="width: {{ $treatment->progress_percentage }}%">
                            {{ $treatment->sessions_completed }}/{{ $treatment->sessions_required }} séances ({{ $treatment->progress_percentage }}%)
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Coût estimé:</strong><br>
                        {{ $treatment->estimated_cost ? number_format($treatment->estimated_cost, 2) . ' €' : '-' }}
                    </div>
                    <div class="col-md-6">
                        <strong>Coût réel:</strong><br>
                        {{ $treatment->actual_cost ? number_format($treatment->actual_cost, 2) . ' €' : '-' }}
                    </div>
                </div>

                @if($treatment->notes)
                    <div class="mb-3">
                        <strong>Notes:</strong>
                        <p class="mt-2">{{ $treatment->notes }}</p>
                    </div>
                @endif
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-primary">
                        <i class="bi bi-pencil me-1"></i>Modifier
                    </a>
                    <form action="{{ route('admin.treatments.destroy', $treatment) }}" method="POST" onsubmit="return confirm('Supprimer ce traitement ?')">
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

    <div class="col-lg-4">
        @if($treatment->medicalFiles->count() > 0)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Fichiers attachés</h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach($treatment->medicalFiles as $file)
                            <li class="mb-2">
                                <i class="bi bi-file-earmark"></i>
                                <a href="{{ route('admin.medical-files.show', $file) }}">
                                    {{ $file->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

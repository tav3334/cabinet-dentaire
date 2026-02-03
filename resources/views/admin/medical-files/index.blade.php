@extends('admin.layouts.admin')

@section('title', 'Fichiers médicaux')
@section('page-title', 'Gestion des fichiers médicaux')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('admin.medical-files.index') }}" method="GET" class="d-flex gap-2">
        <select name="patient_id" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les patients</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                    {{ $patient->full_name }}
                </option>
            @endforeach
        </select>
        <select name="type" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les types</option>
            <option value="xray" {{ request('type') == 'xray' ? 'selected' : '' }}>Radiographie</option>
            <option value="scan" {{ request('type') == 'scan' ? 'selected' : '' }}>Scanner</option>
            <option value="photo" {{ request('type') == 'photo' ? 'selected' : '' }}>Photo</option>
            <option value="document" {{ request('type') == 'document' ? 'selected' : '' }}>Document</option>
            <option value="prescription" {{ request('type') == 'prescription' ? 'selected' : '' }}>Ordonnance</option>
            <option value="report" {{ request('type') == 'report' ? 'selected' : '' }}>Rapport</option>
        </select>
    </form>
    <a href="{{ route('admin.medical-files.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Ajouter un fichier
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($files->count() > 0)
            <div class="row g-3">
                @foreach($files as $file)
                    <div class="col-md-4">
                        <div class="card h-100 border">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-{{ $file->type === 'xray' ? 'primary' : ($file->type === 'document' ? 'secondary' : 'info') }}">
                                        {{ $file->type_label }}
                                    </span>
                                    <small class="text-muted">{{ $file->file_size_formatted }}</small>
                                </div>

                                <h6 class="card-title">{{ $file->title }}</h6>

                                <p class="card-text small text-muted">
                                    <i class="bi bi-person me-1"></i>{{ $file->patient->full_name }}<br>
                                    <i class="bi bi-calendar me-1"></i>{{ $file->document_date ? $file->document_date->format('d/m/Y') : 'Sans date' }}<br>
                                    @if($file->consultation)
                                        <i class="bi bi-clipboard2-pulse me-1"></i>Consultation {{ $file->consultation->consultation_date->format('d/m/Y') }}
                                    @endif
                                </p>

                                @if($file->description)
                                    <p class="card-text small">{{ Str::limit($file->description, 100) }}</p>
                                @endif

                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('admin.medical-files.show', $file) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="bi bi-eye"></i> Voir
                                    </a>
                                    <a href="{{ route('admin.medical-files.download', $file) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-4">
                {{ $files->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark-x fs-1 d-block mb-3"></i>
                <p>Aucun fichier médical enregistré.</p>
            </div>
        @endif
    </div>
</div>
@endsection

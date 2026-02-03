@extends('admin.layouts.admin')

@section('title', 'Gestion des consultations')
@section('page-title', 'Gestion des consultations')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <form action="{{ route('admin.consultations.index') }}" method="GET" class="d-flex gap-2">
        <select name="patient_id" class="form-select" onchange="this.form.submit()">
            <option value="">Tous les patients</option>
            @foreach($patients as $patient)
                <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                    {{ $patient->full_name }}
                </option>
            @endforeach
        </select>
    </form>
    <a href="{{ route('admin.consultations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Nouvelle consultation
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($consultations->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Patient</th>
                            <th>Type</th>
                            <th>Motif</th>
                            <th>Praticien</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($consultations as $consultation)
                            <tr>
                                <td>{{ $consultation->consultation_date->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.patients.show', $consultation->patient) }}">
                                        {{ $consultation->patient->full_name }}
                                    </a>
                                </td>
                                <td><span class="badge bg-info">{{ $consultation->type_label }}</span></td>
                                <td>{{ Str::limit($consultation->chief_complaint ?? '-', 50) }}</td>
                                <td>{{ $consultation->practitioner->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.consultations.show', $consultation) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.consultations.edit', $consultation) }}" class="btn btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $consultations->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-clipboard-x fs-1 d-block mb-3"></i>
                <p>Aucune consultation enregistrée.</p>
            </div>
        @endif
    </div>
</div>
@endsection

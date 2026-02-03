@extends('admin.layouts.admin')

@section('title', 'Gestion des traitements')
@section('page-title', 'Gestion des traitements')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="d-flex gap-2">
        <form action="{{ route('admin.treatments.index') }}" method="GET" class="d-flex gap-2">
            <select name="patient_id" class="form-select" onchange="this.form.submit()">
                <option value="">Tous les patients</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" {{ request('patient_id') == $patient->id ? 'selected' : '' }}>
                        {{ $patient->full_name }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="form-select" onchange="this.form.submit()">
                <option value="">Tous les statuts</option>
                <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planifié</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>En cours</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
            </select>
        </form>
    </div>
    <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Nouveau traitement
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($treatments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Patient</th>
                            <th>Titre</th>
                            <th>Catégorie</th>
                            <th>Dent</th>
                            <th>Statut</th>
                            <th>Progression</th>
                            <th>Coût</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($treatments as $treatment)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.patients.show', $treatment->patient) }}" class="text-decoration-none">
                                        {{ $treatment->patient->full_name }}
                                    </a>
                                </td>
                                <td>{{ $treatment->title }}</td>
                                <td><span class="badge bg-secondary">{{ $treatment->category_label }}</span></td>
                                <td>{{ $treatment->tooth_number ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-{{ $treatment->status === 'completed' ? 'success' : ($treatment->status === 'in_progress' ? 'warning' : 'primary') }}">
                                        {{ $treatment->status_label }}
                                    </span>
                                </td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $treatment->progress_percentage }}%">
                                            {{ $treatment->progress_percentage }}%
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($treatment->actual_cost)
                                        {{ number_format($treatment->actual_cost, 2) }} €
                                    @elseif($treatment->estimated_cost)
                                        <span class="text-muted">{{ number_format($treatment->estimated_cost, 2) }} € (est.)</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $treatment->planned_date ? $treatment->planned_date->format('d/m/Y') : '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.treatments.show', $treatment) }}" class="btn btn-outline-primary">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.treatments.edit', $treatment) }}" class="btn btn-outline-secondary">
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
                {{ $treatments->links() }}
            </div>
        @else
            <div class="text-center py-5 text-muted">
                <i class="bi bi-clipboard-x fs-1 d-block mb-3"></i>
                <p>Aucun traitement enregistré.</p>
            </div>
        @endif
    </div>
</div>
@endsection

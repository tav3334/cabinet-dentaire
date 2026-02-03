@extends('admin.layouts.admin')

@section('title', 'Gestion des patients')
@section('page-title', 'Gestion des patients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <form action="{{ route('admin.patients.index') }}" method="GET" class="d-flex">
            <div class="input-group">
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Rechercher un patient..."
                       value="{{ request('search') }}">
                <button class="btn btn-outline-secondary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </div>
        </form>
    </div>
    <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Nouveau patient
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($patients->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Date de naissance</th>
                            <th>Rendez-vous</th>
                            <th>Inscrit le</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3"
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong>{{ $patient->full_name }}</strong>
                                            @if($patient->gender)
                                                <br>
                                                <small class="text-muted">
                                                    {{ $patient->gender == 'male' ? 'Homme' : ($patient->gender == 'female' ? 'Femme' : 'Autre') }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-envelope me-1 text-muted"></i>{{ $patient->email }}<br>
                                    <i class="bi bi-telephone me-1 text-muted"></i>{{ $patient->phone }}
                                </td>
                                <td>
                                    @if($patient->date_of_birth)
                                        {{ $patient->date_of_birth->format('d/m/Y') }}
                                        <br>
                                        <small class="text-muted">{{ $patient->age }} ans</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $patient->appointments_count }}</span>
                                </td>
                                <td>{{ $patient->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.patients.show', $patient) }}"
                                       class="btn btn-sm btn-outline-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.patients.edit', $patient) }}"
                                       class="btn btn-sm btn-outline-primary" title="Modifier">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.patients.destroy', $patient) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce patient ?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $patients->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people fs-1 text-muted d-block mb-3"></i>
                <h5>Aucun patient trouvé</h5>
                <p class="text-muted">Commencez par ajouter un nouveau patient.</p>
                <a href="{{ route('admin.patients.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg me-2"></i>Ajouter un patient
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

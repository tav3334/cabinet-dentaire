@extends('admin.layouts.admin')

@section('title', 'Gestion des rendez-vous')
@section('page-title', 'Gestion des rendez-vous')

@section('content')
<!-- Filtres -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.appointments.index') }}" method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">Recherche</label>
                <input type="text"
                       name="search"
                       class="form-control"
                       placeholder="Nom ou téléphone..."
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">Statut</label>
                <select name="status" class="form-select">
                    <option value="">Tous</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmé</option>
                    <option value="canceled" {{ request('status') == 'canceled' ? 'selected' : '' }}>Annulé</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">Date</label>
                <input type="date"
                       name="date"
                       class="form-control"
                       value="{{ request('date') }}">
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search me-1"></i>Filtrer
                </button>
                <a href="{{ route('admin.appointments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-x-lg me-1"></i>Réinitialiser
                </a>
            </div>
            <div class="col-md-2 d-flex align-items-end justify-content-end">
                <a href="{{ route('admin.appointments.trashed') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-trash me-1"></i>Corbeille
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Liste des rendez-vous -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if($appointments->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date / Heure</th>
                            <th>Patient</th>
                            <th>Contact</th>
                            <th>Service</th>
                            <th>Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                            <tr class="{{ $appointment->appointment_date->isToday() ? 'table-info' : '' }}">
                                <td>
                                    <strong>{{ $appointment->appointment_date->format('d/m/Y') }}</strong>
                                    @if($appointment->appointment_date->isToday())
                                        <span class="badge bg-info ms-1">Aujourd'hui</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        {{ $appointment->appointment_time ? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') : 'Non spécifié' }}
                                    </small>
                                </td>
                                <td>
                                    <strong>{{ $appointment->name }}</strong>
                                    @if($appointment->message)
                                        <br>
                                        <small class="text-muted" title="{{ $appointment->message }}">
                                            <i class="bi bi-chat-text me-1"></i>
                                            {{ Str::limit($appointment->message, 30) }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <i class="bi bi-telephone me-1 text-muted"></i>{{ $appointment->phone }}
                                </td>
                                <td>
                                    @if($appointment->service)
                                        <span class="badge bg-light text-dark">{{ $appointment->service->title }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm badge-{{ $appointment->status_badge }} dropdown-toggle"
                                                type="button"
                                                data-bs-toggle="dropdown">
                                            {{ $appointment->status_label }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            @foreach(['pending' => 'En attente', 'confirmed' => 'Confirmé', 'canceled' => 'Annulé'] as $status => $label)
                                                @if($appointment->status != $status)
                                                    <li>
                                                        <form action="{{ route('admin.appointments.updateStatus', $appointment->id) }}" method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="{{ $status }}">
                                                            <button type="submit" class="dropdown-item">
                                                                {{ $label }}
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.appointments.show', $appointment->id) }}"
                                       class="btn btn-sm btn-outline-info" title="Voir">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.appointments.destroy', $appointment->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Supprimer ce rendez-vous ?')">
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
                {{ $appointments->withQueryString()->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-muted d-block mb-3"></i>
                <h5>Aucun rendez-vous trouvé</h5>
                <p class="text-muted">Les rendez-vous apparaîtront ici lorsque des patients en prendront.</p>
            </div>
        @endif
    </div>
</div>
@endsection

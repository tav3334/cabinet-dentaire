@extends('admin.layouts.admin')

@section('title', 'Tableau de bord')
@section('page-title', 'Tableau de bord')

@section('content')
<!-- Statistiques -->
<div class="row g-3 mb-4 fade-in">
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card stat-card primary">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-2">
                        <i class="bi bi-calendar-day"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0 small fw-semibold" style="font-size: 11px;">AUJOURD'HUI</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['today_appointments'] }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size: 12px;">Rendez-vous</span>
                    <i class="bi bi-arrow-right text-primary"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card stat-card warning">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-2">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0 small fw-semibold" style="font-size: 11px;">EN ATTENTE</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['pending_appointments'] }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size: 12px;">À confirmer</span>
                    <i class="bi bi-arrow-right text-warning"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card stat-card success">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-2">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0 small fw-semibold" style="font-size: 11px;">CONFIRMÉS</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['confirmed_appointments'] }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size: 12px;">Validés</span>
                    <i class="bi bi-arrow-right text-success"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 col-sm-6">
        <div class="card stat-card danger">
            <div class="card-body p-3">
                <div class="d-flex align-items-center mb-2">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-2">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="flex-grow-1">
                        <p class="text-muted mb-0 small fw-semibold" style="font-size: 11px;">PATIENTS</p>
                        <h3 class="mb-0 fw-bold">{{ $stats['total_patients'] }}</h3>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="text-muted" style="font-size: 12px;">Enregistrés</span>
                    <i class="bi bi-arrow-right text-info"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Rendez-vous d'aujourd'hui -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-check text-primary me-2"></i>
                        Rendez-vous aujourd'hui
                    </h5>
                    <span class="badge bg-primary">{{ $todayAppointments->count() }}</span>
                </div>
            </div>
            <div class="card-body">
                @if($todayAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Heure</th>
                                    <th>Patient</th>
                                    <th>Service</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($todayAppointments as $apt)
                                    <tr>
                                        <td>
                                            <strong>{{ $apt->appointment_time ? \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') : 'N/A' }}</strong>
                                        </td>
                                        <td>{{ $apt->name }}</td>
                                        <td>{{ $apt->service->title ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $apt->status_badge }}">
                                                {{ $apt->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                        Aucun rendez-vous aujourd'hui
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Rendez-vous en attente -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-hourglass-split text-warning me-2"></i>
                        En attente de confirmation
                    </h5>
                    <a href="{{ route('admin.appointments.index') }}?status=pending" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($pendingAppointments->count() > 0)
                    @foreach($pendingAppointments as $apt)
                        <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <div>
                                <strong>{{ $apt->name }}</strong>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $apt->appointment_date->format('d/m/Y') }}
                                    @if($apt->appointment_time)
                                        à {{ \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') }}
                                    @endif
                                </small>
                            </div>
                            <div>
                                <form action="{{ route('admin.appointments.updateStatus', $apt->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="confirmed">
                                    <button type="submit" class="btn btn-sm btn-success" title="Confirmer">
                                        <i class="bi bi-check"></i>
                                    </button>
                                </form>
                                <a href="{{ route('admin.appointments.show', $apt->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                        Aucun rendez-vous en attente
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Prochains rendez-vous -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-week text-info me-2"></i>
                    Prochains rendez-vous (7 jours)
                </h5>
            </div>
            <div class="card-body">
                @if($upcomingAppointments->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>Date</th>
                                    <th>Heure</th>
                                    <th>Patient</th>
                                    <th>Téléphone</th>
                                    <th>Service</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($upcomingAppointments as $apt)
                                    <tr>
                                        <td>{{ $apt->appointment_date->format('d/m/Y') }}</td>
                                        <td>{{ $apt->appointment_time ? \Carbon\Carbon::parse($apt->appointment_time)->format('H:i') : '-' }}</td>
                                        <td>{{ $apt->name }}</td>
                                        <td>{{ $apt->phone }}</td>
                                        <td>{{ $apt->service->title ?? '-' }}</td>
                                        <td>
                                            <span class="badge badge-{{ $apt->status_badge }}">
                                                {{ $apt->status_label }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                        Aucun rendez-vous prévu
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Services populaires -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-star text-warning me-2"></i>
                    Services populaires
                </h5>
            </div>
            <div class="card-body">
                @if($appointmentsByService->count() > 0)
                    @foreach($appointmentsByService as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span>{{ $item->service->title ?? 'Service supprimé' }}</span>
                            <span class="badge bg-primary rounded-pill">{{ $item->total }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <p>Pas encore de données</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Derniers patients -->
        <div class="card border-0 shadow-sm mt-4">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="bi bi-person-plus text-success me-2"></i>
                        Nouveaux patients
                    </h5>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-sm btn-outline-primary">
                        Voir tout
                    </a>
                </div>
            </div>
            <div class="card-body">
                @if($recentPatients->count() > 0)
                    @foreach($recentPatients as $patient)
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-light rounded-circle p-2 me-3">
                                <i class="bi bi-person"></i>
                            </div>
                            <div>
                                <strong>{{ $patient->full_name }}</strong>
                                <br>
                                <small class="text-muted">{{ $patient->created_at ? $patient->created_at->diffForHumans() : 'Récemment' }}</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-4 text-muted">
                        <p>Aucun patient enregistré</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
